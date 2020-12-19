@extends('layouts.app')

@section('content')
    <div class="text-center mt-24">
        <h2 class="text-4xl tracking-tight">
            Create a project
        </h2>
    </div>
    <div class="flex justify-center my-2 mx-4 md:mx-0">
        <form class="w-full max-w-xl bg-white rounded-lg shadow-md p-6">
            <div class="flex flex-wrap -mx-3 mb-6">
                <!-- START title -->
                <div class="w-full md:w-full px-3 mb-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for='title'>
                        Title
                    </label>
                    <input id="title"
                           name="title"
                           class="appearance-none block w-full bg-white text-gray-900 font-medium border border-gray-400 rounded-lg py-3 px-3 leading-tight focus:outline-none"
                           type='text' required>
                </div>
                <!-- END title -->
                <!-- START description -->
                <div class="w-full md:w-full px-3 mb-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for='description'>
                        Description
                    </label>
                    <input id="description"
                           name="description"
                           class="appearance-none block w-full bg-white text-gray-900 font-medium border border-gray-400 rounded-lg py-3 px-3 leading-tight focus:outline-none"
                           type='text' required>
                </div>
                <!-- START description -->
                <div class="w-full md:w-full px-3 mb-6">
                    <button class="appearance-none block w-full bg-blue-900 text-gray-100 font-bold border border-gray-200 rounded-lg py-3 px-3 leading-tight hover:bg-blue-500 focus:outline-none focus:bg-white focus:border-gray-500">
                        Create
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
