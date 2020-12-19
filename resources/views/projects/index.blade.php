@extends('layouts.app')

@section('content')
    <!-- component -->
    <div class="container my-12 mx-auto px-4 md:px-12">
        <div class="">
            <a href={{route('projects.create')}}>
                <button role="link"
                        class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0"
                >Add Project
                </button>
            </a>
        </div>
        <div class="flex flex-wrap -mx-1 lg:-mx-4">
            <!-- Column -->
            @forelse($projects as $project)
                <div class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3">
                    <!-- Article -->
                    <article class="overflow-hidden rounded-lg shadow-lg">
                        <a href="#">
                            <img alt="Placeholder" class="block h-auto w-full"
                                 src="https://picsum.photos/600/400/?random">
                        </a>
                        <header class="flex items-center justify-between leading-tight p-2 md:p-4">
                            <h1 class="text-lg">
                                <a class="no-underline hover:underline text-black" href="{{$project->path()}}">
                                    {{ Str::of( $project->title )->words(3, ' ...')}}
                                </a>
                            </h1>
                        </header>
                        <footer class="flex items-center justify-between leading-none p-2 md:p-4">
                            <a class="flex items-center no-underline hover:underline text-black" href="#">
                                <img alt="Placeholder" class="block rounded-full"
                                     src="https://picsum.photos/32/32/?random">
                                <p class="ml-2 text-sm">
                                    {{$project->owner->name}}
                                </p>
                            </a>
                            <a class="no-underline text-gray-500 hover:text-red-dark" href="#">
                                <span class="">Like</span>
                                <i class="fa fa-heart"></i>
                            </a>
                        </footer>
                    </article>
                    <!-- END Article -->
                </div>
            @empty
                <div class="bg-orange-lightest border-l-4 border-orange text-orange-dark p-4" role="alert">
                    <p class="font-bold">Oops,</p>
                    <p>No projects added</p>
                </div>
        @endforelse
        <!-- END Column -->
        </div>
    </div>
@endsection
