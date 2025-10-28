<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div id="successToast"
                    class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md animate-slide-in">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-green-800 font-semibold">Success!</p>
                            <p class="text-green-700 text-sm">{{ session('success') }}</p>
                        </div>
                        <button onclick="closeToast('successToast')" class="text-green-500 hover:text-green-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                <div id="errorToast"
                    class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md animate-slide-in">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-red-800 font-semibold">Error!</p>
                            <p class="text-red-700 text-sm">{{ session('error') }}</p>
                        </div>
                        <button onclick="closeToast('errorToast')" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div id="validationToast"
                    class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md animate-slide-in">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-red-500 mr-3 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-red-800 font-semibold">Validation Error!</p>
                            <ul class="text-red-700 text-sm mt-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button onclick="closeToast('validationToast')" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
            <!-- Search and Create Button -->
            <div class="p-6 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="w-full sm:w-96">
                    <input type="text" id="searchUser" placeholder="Search by name or email..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <button onclick="openCreateModal()"
                    class="w-full sm:w-auto px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    + Create New User
                </button>
            </div>

            <!-- Users Cards Grid -->
            <div id="usersGrid" class="px-6 pb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($users as $user)
                    <div class="user-card cursor-pointer bg-white border border-gray-200 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl"
                        data-user-name="{{ strtolower($user->name) }}"
                        data-user-email="{{ strtolower($user->email) }}">
                        <div class="p-6">
                            <!-- User Avatar and Name -->
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-semibold text-lg">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>

                            <!-- User Details -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm">
                                    <span class="text-gray-600 font-medium w-24">User Type:</span>
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if($user->user_type == 1) bg-purple-100 text-purple-800
                                        @elseif($user->user_type == 2) bg-blue-100 text-blue-800
                                        @else bg-green-100 text-green-800
                                        @endif">
                                        @if($user->user_type == 1) Admin
                                        @elseif($user->user_type == 2) Shipping Agent
                                        @else Clearance Agent
                                        @endif
                                    </span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <span class="text-gray-600 font-medium w-24">Joined:</span>
                                    <span class="text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2 pt-4 border-t border-gray-200">
                                <button onclick="openEditModal({{ $user->id }})"
                                    class="flex-1 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Edit
                                </button>
                                <button onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                    class="flex-1 px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">No users found.</p>
                    </div>
                @endforelse
            </div>

            <!-- No Results Message -->
            <div id="noResults" class="hidden text-center py-12">
                <p class="text-gray-500 text-lg">No users match your search.</p>
            </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit User Modal -->
    <div id="userModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white animate-modal-appear">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-xl font-semibold text-gray-900">Create New User</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="userForm" method="POST" action="{{ route('register-user') }}">
                @csrf
                <div id="methodField"></div>

                <!-- Name -->
                <div class="mb-4">
                    <label for="modal_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input id="modal_name" type="text" name="name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <span class="text-red-600 text-sm error-message" id="error_name"></span>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="modal_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="modal_email" type="email" name="email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <span class="text-red-600 text-sm error-message" id="error_email"></span>
                </div>

                <!-- Password -->
                <div class="mb-4" id="passwordField">
                    <label for="modal_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="modal_password" type="password" name="password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <span class="text-red-600 text-sm error-message" id="error_password"></span>
                    <p class="text-xs text-gray-500 mt-1 hidden" id="passwordHint">Leave blank to keep current password</p>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4" id="passwordConfirmField">
                    <label for="modal_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input id="modal_password_confirmation" type="password" name="password_confirmation"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <span class="text-red-600 text-sm error-message" id="error_password_confirmation"></span>
                </div>

                <!-- User Type -->
                <div class="mb-6">
                    <label for="modal_user_type" class="block text-sm font-medium text-gray-700 mb-1">User Type</label>
                    <select id="modal_user_type" name="user_type" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select User Type</option>
                        <option value="1">Admin</option>
                        <option value="2">Shipping Agent</option>
                        <option value="3">Clearance Agent</option>
                    </select>
                    <span class="text-red-600 text-sm error-message" id="error_user_type"></span>
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal()"
                        class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn"
                        class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white animate-modal-appear">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Delete User</h3>
                <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete <strong id="deleteUserName"></strong>? This action cannot be undone.</p>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none">
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes modalAppear {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        .animate-modal-appear {
            animation: modalAppear 0.3s ease-out;
        }
    </style>

    <script>
        // Search functionality
        document.getElementById('searchUser').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.user-card');
            const noResults = document.getElementById('noResults');
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.dataset.userName;
                const email = card.dataset.userEmail;

                if (name.includes(searchTerm) || email.includes(searchTerm)) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            noResults.classList.toggle('hidden', visibleCount > 0);
        });

        // Open create modal
        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Create New User';
            document.getElementById('submitBtn').textContent = 'Create User';
            document.getElementById('userForm').action = "{{ route('register-user') }}";
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('passwordHint').classList.add('hidden');
            document.getElementById('modal_password').required = true;
            document.getElementById('modal_password_confirmation').required = true;

            // Clear form
            document.getElementById('userForm').reset();
            clearErrors();

            document.getElementById('userModal').classList.remove('hidden');
        }

        // Open edit modal
        function openEditModal(userId) {
            document.getElementById('modalTitle').textContent = 'Edit User';
            document.getElementById('submitBtn').textContent = 'Update User';
            document.getElementById('passwordHint').classList.remove('hidden');
            document.getElementById('modal_password').required = false;
            document.getElementById('modal_password_confirmation').required = false;

            // Fetch user data
            fetch(`/users/${userId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modal_name').value = data.name;
                    document.getElementById('modal_email').value = data.email;
                    document.getElementById('modal_user_type').value = data.user_type;

                    document.getElementById('userForm').action = `/users/${userId}`;
                    document.getElementById('methodField').innerHTML = '@method("PUT")';

                    clearErrors();
                    document.getElementById('userModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading user data');
                });
        }

        // Close modal
        function closeModal() {
            document.getElementById('userModal').classList.add('hidden');
            document.getElementById('userForm').reset();
            clearErrors();
        }

        // Confirm delete
        function confirmDelete(userId, userName) {
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('deleteForm').action = `/users/${userId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        // Close delete modal
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Clear error messages
        function clearErrors() {
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
        }

        // Close toast notifications
        function closeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => toast.remove(), 300);
            }
        }

        // Auto-hide success/error messages after 5 seconds
        setTimeout(() => {
            const successToast = document.getElementById('successToast');
            const errorToast = document.getElementById('errorToast');
            const validationToast = document.getElementById('validationToast');

            if (successToast) closeToast('successToast');
            if (errorToast) closeToast('errorToast');
            if (validationToast) closeToast('validationToast');
        }, 5000);

        // Close modal when clicking outside
        document.getElementById('userModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modals on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeDeleteModal();
            }
        });

        // Reopen modal if there are validation errors
        @if($errors->any())
            openCreateModal();
        @endif
    </script>
</x-app-layout>
