<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail <strong>{{ $pic->organization->name }}</strong> PIC
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @include('alert')
                    <form action="{{ route('pic.update', [$pic->organization->id, $pic->id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="organization" class="block text-sm font-medium text-gray-700">
                                Organization
                                    </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="organization" id="organization" value="{{ $pic->organization->name }}" autocomplete="off" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" disabled>
                                    </div>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="fullname" class="block text-sm font-medium text-gray-700">
                                Name
                                    </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="fullname" id="fullname" value="{{ $pic->name }}" autocomplete="off" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="phone" class="block text-sm font-medium text-gray-700">
                                    Phone
                                    </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="number" name="phone" id="phone" value="{{ $pic->phone }}" autocomplete="off" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="email" class="block text-sm font-medium text-gray-700">
                                    Email
                                    </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="email" name="email" id="email" value="{{ $pic->email }}" autocomplete="off" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                        <label for="logo" class="block text-sm font-medium text-gray-700">
                                        Avatar
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <img src="{{ asset('storage/avatars/'.$pic->avatar) }}" width="300" height="300" alt="">
                                        </div>
                                    </div>
                                
                                <div class="col-span-3 sm:col-span-2">
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="file" name="avatar" id="avatar" autocomplete="off" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(auth()->user()->manager && auth()->user()->manager->id == $pic->organization->account_manager_id)
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <button type="submit" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                            Save
                            </button>
                        </div>
                        @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
