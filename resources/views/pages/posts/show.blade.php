<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Title -->
        <div class="mb-4">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Post Details</h1>
        </div>

        <!-- Post Details -->
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-sm border border-gray-200 dark:border-gray-800">
            <div class="p-6">
                <!-- Post Title -->
                <div class="mb-4">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $post->title }}</h2>
                </div>

                <!-- Post Description -->
                <div class="mb-4">
                    <p class="text-gray-700 dark:text-gray-300">{{ $post->description }}</p>
                </div>

                <!-- Post Category -->
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Category: <span class="font-normal">{{ $post->category->name }}</span></p>
                </div>

                <!-- Post Cover Photo -->
                @if($post->cover_photo)
                    <div class="mb-4">
                        <img src="{{asset('storage/' . $post->cover_photo) }}" alt="Cover Photo" class="w-full max-w-xs rounded-md shadow-sm">
                    </div>
                @endif

                <!-- Buttons -->
                <div class="flex space-x-4 mt-4">
                    <a href="{{ route('posts.edit', $post) }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white rounded-md px-4 py-2">
                        Edit Post
                    </a>
                    
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn bg-red-600 text-white hover:bg-red-500 dark:bg-red-500 dark:hover:bg-red-400 rounded-md px-4 py-2">
                            Delete Post
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
