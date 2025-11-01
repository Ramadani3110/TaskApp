<div class="lg:mx-10 md:mx-10 sm:mx-5 mx-2 my-3">
    <div
        class="mt-5 max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Welcome Back
            </h5>
        </a>
        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
            {{ Auth::user()->name }}, here is a summary of your tasks.
        </p>
        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
            You have
            <span class="font-bold">{{ $todayTask }}</span>
            pending tasks today.
        </p>
    </div>

    <section class="bg-gray-50 dark:bg-gray-900 mt-5">
        <div class="mx-auto w-full ">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-visible">
                <div
                    class="px-4 sm:px-6 pt-6 pb-4 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h5 class="text-2xl font-bold text-gray-900 dark:text-white leading-snug mb-3 sm:mb-0">
                        All Tasks
                    </h5>
                    <div
                        class="w-full sm:w-auto flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-2 sm:gap-3">
                        <button type="button" wire:click="openAddModal"
                            class="flex items-center justify-center w-full sm:w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-all duration-150">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 12h14m-7 7V5" />
                            </svg>
                            Add Task
                        </button>
                    </div>
                </div>


                <div class="flex flex-col md:flex-row items-center gap-4 px-4 pb-4 pt-4">
                    <!-- Search Bar -->
                    <div class="w-full md:flex-1 flex items-center">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="simple-search" wire:model.live="search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 h-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search">
                        </div>
                    </div>

                    <!-- Filter by Due Date -->
                    <div class="w-full md:w-48 flex flex-col md:flex-row md:items-center">
                        <label for="filter-due"
                            class="whitespace-nowrap text-gray-900 dark:text-white text-sm font-medium mb-1 md:mb-0 md:mr-2">Due
                            Date</label>
                        <select id="filter-due" wire:model.live="filterDue"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full h-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">All</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                    </div>

                    <!-- Filter by Status -->
                    <div class="w-full md:w-48 flex flex-col md:flex-row md:items-center">
                        <label for="filter-status"
                            class="whitespace-nowrap text-gray-900 dark:text-white text-sm font-medium mb-1 md:mb-0 md:mr-2">Status</label>
                        <select id="filter-status" wire:model.live="filterStatus"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full h-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">All</option>
                            <option value="pending">Pending</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                </div>


                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Title</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3">Due Date</th>
                                <th scope="col" class="px-4 py-3 w-40">Mark as Done</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody wire:loading.remove wire:target="search">
                            @forelse ($task as $tasks)
                            <tr wire:key='task-{{ $tasks->id }}' class="border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $tasks->title }}
                                </th>
                                <td class="px-4 py-3">
                                    @if($tasks->status == 'done')
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                        {{ $tasks->status }}
                                    </span>
                                    @else
                                    <span
                                        class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                                        {{ $tasks->status }}
                                    </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $tasks->due_date }}</td>
                                <td class="px-4 py-3 text-center w-40 relative">
                                    <div class="flex items-center justify-center">
                                        <input id="default-checkbox" type="checkbox" wire:loading.remove
                                            wire:click="toggleDone({{ $tasks->id }})" wire:loading.attr="disabled"
                                            wire:target="toggleDone({{ $tasks->id }})" {{ $tasks->status == 'done' ?
                                        'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm
                                        focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800
                                        focus:ring-2 dark:bg-gray-700 dark:border-gray-600">

                                        <!-- Spinner -->
                                        <div wire:loading wire:target="toggleDone({{ $tasks->id }})" role="status">
                                            <svg aria-hidden="true"
                                                class="w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                    fill="currentFill" />
                                            </svg>
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 flex items-center justify-end">
                                    <div class="inline-flex rounded-md shadow-xs" role="group">
                                        <button type="button" wire:click="showDetail({{ $tasks->id }})"
                                            class="hover:cursor-pointer px-3 py-1 text-sm font-medium text-gray-900 bg-yellow-600 border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </button>
                                        <button type="button" wire:click='edit({{$tasks->id}})'
                                            class="hover:cursor-pointer px-3 py-1 text-sm font-medium text-gray-900 bg-blue-600 border-t border-b border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                            </svg>
                                        </button>
                                        <button type="button" wire:click="confirmDelete({{ $tasks->id }})"
                                            class="hover:cursor-pointer px-3 py-1 text-sm font-medium text-gray-900 bg-red-600 border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">
                                    No data found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $task->links() }}
                </div>
            </div>
        </div>
    </section>

    @if ($showAddModal)
    <div class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm"></div>
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Create New Task
                    </h3>
                    <button type="button" wire:click="closeAddModal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" wire:submit.prevent="store">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Title
                            </label>
                            <input type="text" name="title" id="title" wire:model="title" class="bg-gray-50 border
                            @error('title')
                            border-red-500 focus:border-red-500 focus:ring-red-500
                            @enderror
                            text-gray-900 text-sm rounded-lg block w-full p-2.5
                            dark:bg-gray-600 dark:text-white dark:placeholder-gray-400" placeholder="Title">
                            @error('title')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-span-2">
                            <label for="due_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Due Date
                            </label>
                            <div class="relative max-w-sm">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input datepicker wire:model="due_date" id="default-datepicker" type="text" class="bg-gray-50 border
                                @error('due_date')
                                border-red-500 focus:border-red-500 focus:ring-red-500
                                @enderror
                                text-gray-900 text-sm rounded-lg block w-full ps-10 p-2.5
                                dark:bg-gray-600 dark:text-white dark:placeholder-gray-400" placeholder="Select date">
                            </div>
                            @error('due_date')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-span-2">
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Description
                            </label>
                            <textarea id="description" rows="4" wire:model="description" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border
                            @error('description')
                            border-red-500 focus:border-red-500 focus:ring-red-500
                            @enderror
                            dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                placeholder="Write task description here"></textarea>
                            @error('description')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <!-- Tombol aksi -->
                    <div class="flex justify-end space-x-3 mt-4">
                        <button type="submit" wire:loading.attr="disabled" wire:target="store"
                            wire:loading.class="cursor-not-allowed opacity-70"
                            wire:loading.class.remove="hover:cursor-pointer"
                            class="text-white inline-flex items-center hover:cursor-pointer bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 12h14m-7 7V5" />
                            </svg>
                            Add new task
                        </button>

                        <button type="button" wire:target="store" wire:click="closeAddModal"
                            wire:loading.class="cursor-not-allowed opacity-70"
                            wire:loading.class.remove="hover:cursor-pointer"
                            class="text-white inline-flex items-center hover:cursor-pointer bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Cancel
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    @endif

    @if ($showDetailModal)
    <div class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm"></div>
    <div id="detail-modal" tabindex="-1" aria-hidden="true"
        class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Task Details
                    </h3>
                    <button type="button" wire:click="$set('showDetailModal', false)"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="detail-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-2">
                    <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                        <div class="flex flex-col ">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Title</dt>
                            <dd class="text-lg font-semibold">{{ $detailTask->title ?? '-' }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Description</dt>
                            <dd class="text-lg font-semibold">{{ $detailTask->description ?? '-' }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Due Date</dt>
                            <dd class="text-lg font-semibold">{{ $detailTask->due_date ?? '-' }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Status</dt>
                            <dd class="text-lg font-semibold">
                                @if($detailTask->status ?? false)
                                @if($detailTask->status == 'done')
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                    {{ $detailTask->status }}
                                </span>
                                @else
                                <span
                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                                    {{ $detailTask->status }}
                                </span>
                                @endif
                                @else
                                -
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
                <!-- Modal footer -->
                <div class="flex justify-end space-x-3 mt-4 p-4 md:p-5 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" wire:click="$set('showDetailModal', false)"
                        class="text-white inline-flex items-center hover:cursor-pointer bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($showEditModal)
    <div class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm"></div>
    <div id="edit-modal" tabindex="-1" aria-hidden="true"
        class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit Task
                    </h3>
                    <button type="button" wire:click="closeEditModal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" wire:submit.prevent="update">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="edit-title"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Title
                            </label>
                            <input type="text" id="edit-title" wire:model="title" class="bg-gray-50 border
                                @error('title') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror
                                text-gray-900 text-sm rounded-lg block w-full p-2.5
                                dark:bg-gray-600 dark:text-white dark:placeholder-gray-400" placeholder="Title">
                            @error('title')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-span-2">
                            <label for="edit-due_date"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Due Date
                            </label>
                            <div class="relative max-w-sm">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input datepicker wire:model="due_date" id="edit-due_date" type="text" class="bg-gray-50 border
                                    @error('due_date') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror
                                    text-gray-900 text-sm rounded-lg block w-full ps-10 p-2.5
                                    dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                    placeholder="Select date">
                            </div>
                            @error('due_date')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-span-2">
                            <label for="edit-description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Description
                            </label>
                            <textarea id="edit-description" rows="4" wire:model="description" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border
                                @error('description') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror
                                dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                placeholder="Write task description here"></textarea>
                            @error('description')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol aksi -->
                    <div class="flex justify-end space-x-3 mt-4">
                        <button type="submit" wire:loading.attr="disabled" wire:target="update"
                            wire:loading.class="cursor-not-allowed opacity-70"
                            wire:loading.class.remove="hover:cursor-pointer"
                            class="text-white inline-flex items-center hover:cursor-pointer bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                            </svg>
                            Save Changes
                        </button>

                        <button type="button" wire:click="closeEditModal"
                            wire:loading.class="cursor-not-allowed opacity-70"
                            wire:loading.class.remove="hover:cursor-pointer"
                            class="text-white inline-flex items-center hover:cursor-pointer bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    @if($showDeleteModal)
    <div class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm"></div>
    <div
        class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <button type="button" wire:click="$set('showDeleteModal', false)"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                        Are you sure you want to delete this task?
                    </h3>
                    <button wire:click="deleteTask" wire:loading.attr="disabled" wire:target="deleteTask"
                        wire:loading.class="cursor-not-allowed opacity-70"
                        wire:loading.class.remove="hover:cursor-pointer"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, I'm sure
                    </button>
                    <button wire:click="$set('showDeleteModal', false)"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        No, cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif


</div>

@push('js')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('init-datepicker', () => {
            setTimeout(() => {
                const datepickerEl = document.getElementById('default-datepicker');

                if (datepickerEl && typeof Datepicker !== 'undefined') {
                    const picker = new Datepicker(datepickerEl, {
                        autohide: true,
                    });

                    datepickerEl.addEventListener('changeDate', (event) => {
                        const selectedDate = datepickerEl.value;
                        Livewire.find(
                            datepickerEl.closest('[wire\\:id]').getAttribute('wire:id')
                        ).set('due_date', selectedDate);
                    });
                } else {
                    console.warn('Datepicker Error.');
                }
            }, 300);
        });
        Livewire.on('init-edit-datepicker', () => {
            setTimeout(() => {
                const datepickerEl = document.getElementById('edit-due_date');

                if (datepickerEl && typeof Datepicker !== 'undefined') {
                    const picker = new Datepicker(datepickerEl, {
                        autohide: true,
                    });

                    datepickerEl.addEventListener('changeDate', (event) => {
                        const selectedDate = datepickerEl.value;
                        Livewire.find(
                            datepickerEl.closest('[wire\\:id]').getAttribute('wire:id')
                        ).set('due_date', selectedDate);
                    });
                } else {
                    console.warn('Edit Datepicker Error.');
                }
            }, 300);
        });
    });
</script>
@endpush