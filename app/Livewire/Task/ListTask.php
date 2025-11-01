<?php

namespace App\Livewire\Task;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use SweetAlert2\Laravel\Traits\WithSweetAlert;

#[Title('My Tasks')]
class ListTask extends Component
{
    use WithSweetAlert, WithPagination;
    public $todayTask;
    public $detailTask;
    public $editTaskId;
    public $search = '';
    public $filterStatus = '';
    public $filterDue = '';
    public $showAddModal = false;
    public $showDetailModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $taskToDelete = null;


    #[Validate('required|string|max:50')]
    public $title = '';
    #[Validate('required|string|max:255')]
    public $description = '';
    #[Validate('required|date')]
    public $due_date = '';
    #[Validate('required|in:pending,completed')]
    public $status = 'pending';

    public function store()
    {
        $this->validate();

        try {
            $formattedDate = $this->due_date;

            if ($this->due_date && str_contains($this->due_date, '/')) {
                $formattedDate = Carbon::createFromFormat('m/d/Y', $this->due_date)->format('Y-m-d');
            }
            Task::create([
                'user_id' => Auth::id(),
                'title' => $this->title,
                'description' => $this->description,
                'due_date' => $formattedDate,
                'status' => $this->status,
            ]);

            $this->title = '';
            $this->description = '';
            $this->due_date = '';
            $this->status = 'pending';

            $this->swalSuccess([
                'title' => 'Task Created',
                'text' => 'Your task has been created successfully.',
            ]);
            $this->closeAddModal();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->showAddModal = true;
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error creating task: ' . $e->getMessage());
            $this->swalError([
                'title' => 'Error',
                'text' => 'There was an error creating the task. Please try again.',
            ]);
        }
    }

    public function edit($id)
    {
        $task = Task::find($id);
        if ($task->user_id !== Auth::id()) {
            $this->swalError([
                'title' => 'Unauthorized',
                'text' => 'You are not authorized to edit this task.',
            ]);
            $this->showEditModal = true;
            $this->dispatch('init-edit-datepicker');
        } else {
            $this->editTaskId = $id;
            $this->title = $task->title;
            $this->description = $task->description;
            $this->due_date = Carbon::parse($task->due_date)->format('m/d/Y');
            $this->status = $task->status;
            $this->showEditModal = true;
            $this->dispatch('init-edit-datepicker');
        }
    }

    public function update()
    {
        $this->validate();
        try {
            $task = Task::find($this->editTaskId);

            if ($task->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            $formattedDate = $this->due_date;

            if ($this->due_date && str_contains($this->due_date, '/')) {
                $formattedDate = Carbon::createFromFormat('m/d/Y', $this->due_date)->format('Y-m-d');
            }

            $task->update([
                'title' => $this->title,
                'description' => $this->description,
                'due_date' => $formattedDate,
                'status' => $this->status,
            ]);

            $this->swalSuccess([
                'title' => 'Task Updated',
                'text' => 'Your task has been updated successfully.',
            ]);
            $this->reset(['title', 'description', 'due_date', 'status', 'editTaskId']);
            $this->showEditModal = false;
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->showEditModal = true;
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error updating task: ' . $e->getMessage());
            $this->swalError([
                'title' => 'Error',
                'text' => 'There was an error updating the task. Please try again.',
            ]);
        }
    }

    public function confirmDelete($id)
    {
        $this->taskToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function deleteTask()
    {
        try {
            $task = Task::find($this->taskToDelete);
            if ($task->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
            $task->delete();
            $this->showDeleteModal = false;
            $this->taskToDelete = null;

            $this->swalSuccess([
                'title' => 'Task Deleted',
                'text' => 'The task has been deleted successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting task: ' . $e->getMessage());
            $this->swalError([
                'title' => 'Error',
                'text' => 'There was an error deleting the task. Please try again.',
            ]);
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['title', 'description', 'due_date', 'status', 'editTaskId']);
    }

    public function toggleDone($id)
    {
        $task = Task::find($id);
        $task->status = $task->status === 'done' ? 'pending' : 'done';
        $task->save();
    }

    public function openAddModal()
    {
        $this->resetValidation();
        $this->showAddModal = true;
        $this->dispatch('init-datepicker');
    }

    public function closeAddModal()
    {
        $this->reset();
        $this->showAddModal = false;
    }

    public function showDetail($id)
    {
        $this->detailTask = Task::find($id);
        $this->showDetailModal = true;
    }

    public function render()
    {
        $this->todayTask = Task::dueToday()
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        $query = Task::select('id', 'title', 'status', 'due_date')
            ->where('user_id', Auth::id());

        if (!empty($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        if (!empty($this->filterDue)) {
            switch ($this->filterDue) {
                case 'today':
                    $query->whereDate('due_date', now()->format('Y-m-d'));
                    break;
                case 'week':
                    $query->whereBetween('due_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('due_date', now()->month)
                        ->whereYear('due_date', now()->year);
                    break;
            }
        }

        $tasks = $query->latest()->paginate(5);

        return view('livewire.task.list-task', [
            'task' => $tasks,
        ]);
    }
}
