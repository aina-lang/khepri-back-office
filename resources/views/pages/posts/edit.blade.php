<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Title -->
        <div class="mb-4">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Edit Post</h1>
        </div>

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <!-- Edit Form -->
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-sm border border-gray-200 dark:border-gray-800">
            <div class="p-6">
                <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" class="form-input w-full mt-1 @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea id="description" name="description" rows="4" class="form-textarea w-full mt-1 @error('description') border-red-500 @enderror">{{ old('description', $post->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                        <select id="category_id" name="category_id" required class="form-select mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                            <option value="" disabled>Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cover Photo -->
                    <div class="mb-4">
                        <label for="cover_photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cover Photo</label>
                        <input type="file" id="cover_photo" name="cover_photo" class="form-input mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" accept="image/*" onchange="previewImage(event)">
                        <div id="image-preview" class="mt-2">
                            @if($post->cover_photo)
                                <img id="preview" src="{{ Storage::url($post->cover_photo) }}" alt="Cover Photo Preview" class="w-full max-w-xs rounded-md shadow-sm">
                            @else
                                <img id="preview" src="" alt="Cover Photo Preview" class="hidden w-full max-w-xs rounded-md shadow-sm">
                            @endif
                        </div>
                        @error('cover_photo')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white rounded-md px-4 py-2">
                            Update Post
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- JavaScript for Image Preview -->
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            var preview = document.getElementById('preview');
            
            reader.onload = function() {
                preview.src = reader.result;
                preview.classList.remove('hidden');
            }

            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
