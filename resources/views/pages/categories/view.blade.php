<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Posts</h1>
            </div>

            <!-- Right: Actions -->
            <div class="flex flex-row space-x-3 sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Search form -->
                <input type="text" id="searchInput" placeholder="Search posts..."
                    class="form-input w-full max-w-xs mb-4 border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" />

                <!-- Add new post button -->
                <a href="{{ route('posts.create') }}"
                    class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white rounded-md px-4 py-2">
                    <svg class="fill-current shrink-0 xs:hidden" width="16" height="16" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="max-xs:sr-only">Add Post</span>
                </a>

            </div>

        </div>

        <!-- Posts table -->
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-sm border border-gray-200 dark:border-gray-800">
            <div class="p-3">

                <table id="postsTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th id="titleHeader"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer">
                                Title</th>
                            <th id="descriptionHeader"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer">
                                Description</th>
                            <th id="archiveHeader"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Archived</th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="postsTableBody"
                        class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($posts as $post)
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $post->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ Str::limit($post->description, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    <label class="inline-flex relative items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only archive-switch"
                                            data-id="{{ $post->id }}" {{ $post->archived ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 rounded-full shadow-inner"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full shadow">
                                        </div>
                                        <span
                                            class="ml-2 text-sm text-gray-600 dark:text-gray-300">{{ $post->archived ? 'Archived' : 'Not Archived' }}</span>
                                    </label>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('posts.show', $post->id) }}"
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400">View</a>
                                    <a href="{{ route('posts.edit', $post->id) }}"
                                        class="ml-4 text-yellow-600 hover:text-yellow-900 dark:text-yellow-400">Edit</a>
                                    <button data-id="{{ $post->id }}"
                                        class="ml-4 text-red-600 hover:text-red-900 dark:text-red-400 delete-button">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $posts->links() }}
                </div>

            </div>
        </div>

    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-sm w-full p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Confirm Deletion</h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Are you sure you want to delete this post?</p>
            <div class="flex justify-end mt-4">
                <button id="confirmDelete"
                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Delete</button>
                <button id="cancelDelete"
                    class="ml-2 bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-200 dark:bg-gray-600 dark:text-gray-100 dark:hover:bg-gray-500">Cancel</button>
            </div>
        </div>
    </div>

    <!-- JavaScript for Search, Sort, and Modal Functionality -->
    <script>
        // Fonctionnalité de recherche
        document.getElementById('searchInput').addEventListener('input', function() {
            var searchTerm = this.value.toLowerCase();
            var table = document.getElementById('postsTable');
            var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (var i = 0; i < rows.length; i++) {
                var titleCell = rows[i].getElementsByTagName('td')[0];
                var descriptionCell = rows[i].getElementsByTagName('td')[1];

                if (titleCell && descriptionCell) {
                    var titleText = titleCell.textContent || titleCell.innerText;
                    var descriptionText = descriptionCell.textContent || descriptionCell.innerText;

                    if (titleText.toLowerCase().indexOf(searchTerm) > -1 || descriptionText.toLowerCase().indexOf(
                            searchTerm) > -1) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        });

        // Fonction de tri
        function sortTable(n, asc) {
            var table = document.getElementById('postsTable');
            var rows = Array.from(table.getElementsByTagName('tbody')[0].getElementsByTagName('tr'));
            var sortedRows;

            sortedRows = rows.sort(function(a, b) {
                var x = a.getElementsByTagName('td')[n].textContent || a.getElementsByTagName('td')[n].innerText;
                var y = b.getElementsByTagName('td')[n].textContent || b.getElementsByTagName('td')[n].innerText;

                if (asc) {
                    return x.localeCompare(y);
                } else {
                    return y.localeCompare(x);
                }
            });

            for (var i = 0; i < sortedRows.length; i++) {
                table.getElementsByTagName('tbody')[0].appendChild(sortedRows[i]);
            }
        }

        // Ajouter des écouteurs d'événements aux en-têtes
        document.getElementById('titleHeader').addEventListener('click', function() {
            var ascending = !this.classList.contains('asc');
            sortTable(0, ascending);
            this.classList.toggle('asc', ascending);
        });

        document.getElementById('descriptionHeader').addEventListener('click', function() {
            var ascending = !this.classList.contains('asc');
            sortTable(1, ascending);
            this.classList.toggle('asc', ascending);
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.archive-switch').forEach(function(switchElement) {
                switchElement.addEventListener('change', function() {
                    var postId = this.getAttribute('data-id');
                    var isArchived = this.checked ? 1 : 0;

                    fetch(`/posts/${postId}/archive`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                archived: isArchived
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Statut de l\'archive du post mis à jour');
                            } else {
                                console.error('Échec de la mise à jour du statut d\'archive');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur :', error);
                        });
                });
            });
        });

        // Fonctionnalité de suppression de post
        var deleteId = null;
        document.querySelectorAll('.delete-button').forEach(function(button) {
            button.addEventListener('click', function() {
                deleteId = this.getAttribute('data-id');
                document.getElementById('confirmationModal').classList.remove('hidden');
            });
        });

        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (deleteId) {
                fetch(`/posts/${deleteId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            console.error('Échec de la suppression du post');
                        }
                    });
            }
        });

        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('confirmationModal').classList.add('hidden');
        });
    </script>
</x-app-layout>
