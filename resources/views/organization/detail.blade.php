@section('css')
	@include('datatable-css')
@stop
@section('js')
	@include('datatable-js')
@stop
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Organization
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @include('alert')
                    <form action="{{ route('org.update',$organization->id) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-">
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="fullname" class="block text-sm font-medium text-gray-700">
                                        Account Manager
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" value="{{ ($organization->manager) ? $organization->manager->fullname : '' }}" autocomplete="off" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" disabled>
                                        </div>
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="fullname" class="block text-sm font-medium text-gray-700">
                                        Name
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="fullname" id="fullname" value="{{ $organization->name }}" autocomplete="off" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                        </div>
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="phone" class="block text-sm font-medium text-gray-700">
                                        Phone
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="number" name="phone" id="phone" value="{{ $organization->phone }}" autocomplete="off" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                        </div>
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="email" class="block text-sm font-medium text-gray-700">
                                        Email
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="email" name="email" id="email" value="{{ $organization->email }}" autocomplete="off" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                        </div>
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="website" class="block text-sm font-medium text-gray-700">
                                        Website
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="website" id="website" value="{{ $organization->website }}" autocomplete="off" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                        </div>
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="logo" class="block text-sm font-medium text-gray-700">
                                        Logo
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <img src="{{ asset('storage/organizations/'.$organization->logo) }}" width="300" height="300" alt="">
                                        </div>
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="file" name="logo" id="logo" autocomplete="off" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(auth()->user()->manager && auth()->user()->manager->id == $organization->account_manager_id)
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <button type="submit" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                Update
                                </button>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6 bg-white border-b border-gray-200">
                    @include('alert')
                    @if(auth()->user()->manager && auth()->user()->manager->id == $organization->account_manager_id)
                    <a href="{{ route('pic.create',$organization->id) }}" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        Add PIC
                    </a>
                    @endif
                <br>
                <br>
                
                <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
					<thead>
						<tr>
							<th data-priority="1">Name</th>
							<th data-priority="2">Email</th>
							<th data-priority="2">Phone</th>
							<th data-priority="2">Action</th>
						</tr>
					</thead>
					<tbody>
                        @foreach($organization->pic as $pic)
						<tr>
							<td>{{ $pic->name }}</td>
							<td>{{ $pic->email }}</td>
							<td>{{ $pic->phone }}</td>
							<td align="center"><a href="{{ route('pic.detail',[$organization->id, $pic->id]) }}" class="h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-blue-700 rounded-lg focus:shadow-outline hover:bg-indigo-800">Detail</a>
                            @if(auth()->user()->manager && auth()->user()->manager->id == $organization->account_manager_id)
							<a href="{{ route('pic.delete',[$organization->id, $pic->id]) }}" class="h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-blue-700 rounded-lg focus:shadow-outline hover:bg-indigo-800">Delete</a>
                            @endif
							</td>
						</tr>
                        @endforeach
					</tbody>
				</table>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        
    </div>
</x-app-layout>
