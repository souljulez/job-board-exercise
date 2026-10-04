<x-layout>
    <x-breadcrumbs :links="['My Jobs' => '#']" class="mb-4" />

    <div class="mb-8 text-right">
        <x-link-button href="{{ route('my-jobs.create') }}">Add New</x-link-button>
    </div>

    @forelse($jobs as $job)
        <x-job-card :$job>
            <div class="text-xs text-slate-500">
                @forelse($job->jobApplications as $application)
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <div>{{ $application->user->name }}</div>
                            <div>
                                Applied {{  $application->created_at->diffForHumans() }}
                            </div>
                            <div>
                                @php
                                    $encryptedPath = Crypt::encryptString($application->cv_path);
                                @endphp
                                <a href="{{ route('file.download', ['filepath' => $encryptedPath]) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-4 rounded inline-flex items-center">
                                    <span>Download CSV</span>
                                </a>
                            </div>
                        </div>
                        <div>${{ number_format($application->expected_salary) }}</div>
                    </div>
                @empty
                    No applications yet.
                @endforelse

                <div class="flex space-x-2 mt-2">
                    <x-link-button href="{{ route('my-jobs.edit', $job) }}">Edit</x-link-button>
                    <form action="{{ route('my-jobs.destroy', $job) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        @if(!$job->deleted_at)
                            <x-button>Delete</x-button>
                        @endif
                    </form>
                </div>
            </div>
        </x-job-card>
    @empty
       <div class="rounded-md border border-dashed border-slate-300 p-8">
        <div class="text-center font-medium">
            No jobs yet
        </div>
        <div class="text-center">
            Post your first job <a class=text-indigo-500 hover:underline"
                href="{{ route('my-jobs.create') }}"> here!</a>
        </div>
       </div>
    @endforelse

</x-layout>
