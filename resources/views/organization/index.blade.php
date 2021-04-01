@section('css')
	@include('datatable-css')
@stop
@section('js')
	@include('datatable-js')
@stop

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Organization
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6 bg-white border-b border-gray-200">
                    @include('alert')
                <a href="{{ route('org.create') }}" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                    Create Organization
                </a>
                <br>
                <br>
                
                <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
					<thead>
						<tr>
							<th data-priority="1">Name</th>
							<th data-priority="2">Email</th>
							<th data-priority="2">Website</th>
							<th data-priority="2">PIC</th>
							<th data-priority="2">Managed By</th>
							<th data-priority="2">Action</th>
						</tr>
					</thead>
					<tbody>
                        @foreach($organizations as $organization)
						<tr>
							<td>{{ $organization->name }}</td>
							<td>{{ $organization->email }}</td>
							<td>{{ $organization->website }}</td>
							<td>
								@foreach($organization->pic as $pic)
									<li>{{ $pic->name }}</li>
								@endforeach
							</td>
							<td>{{ ($organization->manager ? $organization->manager->fullname : '') }}</td>
							<td><a href="{{ route('org.detail',$organization->id) }}" class="h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-blue-700 rounded-lg focus:shadow-outline hover:bg-indigo-800">Detail</a>
							@if(auth()->user()->user_type == ADMIN)
							<a href="{{ route('org.add-manager',$organization->id) }}" class="h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-blue-700 rounded-lg focus:shadow-outline hover:bg-indigo-800">Manager</a>
							@endif
							@if(auth()->user()->manager && auth()->user()->manager->id == $organization->account_manager_id)
							<a href="{{ route('org.delete',$organization->id) }}" class="h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-blue-700 rounded-lg focus:shadow-outline hover:bg-indigo-800">Delete</a>
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
</x-app-layout>
