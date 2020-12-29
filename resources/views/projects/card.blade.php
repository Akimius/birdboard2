<div class="bg-white rounded-lg shadow p-5" style="height:200px;box-sizing: content-box;">
    <h3 class="font-normal text-xl mb-6 py-4 -ml-5 mb-3 border-l-4 border-blue-light pl-4">
        <a href="{{ $project->path() }}" class="text-black no-underline">
            {{ Str::of($project->title)->words(3, ' ...') }}
        </a>
    </h3>
    <div class="text-gray-500">{{ Str::of($project->description)->words(15) }}</div>
</div>