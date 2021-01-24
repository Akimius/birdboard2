<!-- View extends layouts/app.blade.php -->
@extends ('layouts.app')
@section('content')

    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-grey text-sm font-normal">
                <a href="/projects" class="text-grey text-sm font-normal no-underline">My Projects</a>
                / {{ $project->title }}
            </p>
            <a href="{{$project->path() . '/edit'}}" class="button bg-blue">Edit project</a>

        </div>

    </header>

    <main>

        <div class="lg:flex -mx-3">

            <div class="lg:w-3/4 px-3 mb-6">

                <div class="mb-6">

                    <!-- Tasks -->
                    <h2 class="text-grey font-normal text-lg mb-3">Tasks</h2>

                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="POST"
                                  action="{{ $task->path()}}">
                                @method('PATCH')
                                @csrf
                                <div class="flex">
                                    <input name="body"
                                           value="{{ $task->body }}"
                                           class="w-full {{ $task->completed ? 'border-l-4 border-green-500 text-gray-300' : 'border-l-4 border-red-500' }}">
                                    <input name="completed"
                                           type="checkbox"
                                           onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf
                            <input type="text" name="body" placeholder="Add a new task.." class="w-full">
                        </form>

                    </div>

                </div>

                <div class="mb-6">
                    <form method="POST" action="{{$project->path()}}">
                        @csrf
                        @method('PATCH')
                        <!-- General Notes -->
                        <h2 class="text-grey font-normal text-lg mb-3">General Notes</h2>
                        <textarea class="card w-full"
                                  name="notes"
                                  style="min-height: 200px;"
                                  placeholder="Anything special"
                        >{{$project->notes}}</textarea>
                        <button type="submit" class="button mt-2">Save</button>
                    </form>
                </div>
            </div>
            <div class="lg:w-1/4 px-3">
                @include ('projects.card')
                <a href="/projects">Go Back</a>
            </div>

        </div>

    </main>

@endsection