<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $table->name }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Table
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            <div id="messageContainer"></div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header with Add Row Button -->
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $table->name }}</h3>
                            @if($table->description)
                                <p class="text-sm text-gray-600 mt-1">{{ $table->description }}</p>
                            @endif
                        </div>
                        <button onclick="addNewRow()"
                            style="background-color: #2563eb; color: white; padding: 0.625rem 1.25rem; border-radius: 0.5rem; font-weight: 600; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); transition: all 0.2s;"
                            onmouseover="this.style.backgroundColor='#1d4ed8'; this.style.transform='scale(1.05)'"
                            onmouseout="this.style.backgroundColor='#2563eb'; this.style.transform='scale(1)'">
                            <svg style="width: 1.25rem; height: 1.25rem; display: inline; margin-right: 0.5rem; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span style="vertical-align: middle;">Add New Row</span>
                        </button>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200 border border-gray-300 table-fixed" id="dataTable" style="min-width: 2000px;">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 whitespace-nowrap" style="width: 60px;">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 whitespace-nowrap" style="width: 180px;">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 whitespace-nowrap" style="width: 180px;">Part No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 whitespace-nowrap" style="width: 180px;">Brand Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 whitespace-nowrap" style="width: 120px;">Unit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 whitespace-nowrap" style="width: 180px;">PO Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 whitespace-nowrap" style="width: 150px;">Vsl</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 whitespace-nowrap" style="width: 180px;">BL Num</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 whitespace-nowrap" style="width: 150px;">ETD</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 whitespace-nowrap" style="width: 150px;">Revised ETD</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 whitespace-nowrap" style="width: 150px;">ETA</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 whitespace-nowrap" style="width: 150px;">Revised ETA</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 whitespace-nowrap" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                                @forelse($table->rows as $index => $row)
                                    <tr data-row-id="{{ $row->id }}" class="hover:bg-gray-50 cursor-pointer" ondblclick="editRow(this)">
                                        <td class="px-6 py-4 border border-gray-300 text-sm whitespace-nowrap" style="width: 60px;">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 180px;" data-field="category">{{ $row->category }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 180px;" data-field="part_no">{{ $row->part_no }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 180px;" data-field="brand_name">{{ $row->brand_name }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 120px;" data-field="unit">{{ $row->unit }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 180px;" data-field="po_number">{{ $row->po_number }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 150px;" data-field="vsl">{{ $row->vsl }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 180px;" data-field="bl_num">{{ $row->bl_num }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm whitespace-nowrap" style="width: 150px;" data-field="etd">{{ $row->etd ? $row->etd->format('Y-m-d') : '' }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm whitespace-nowrap" style="width: 150px;" data-field="revised_etd">{{ $row->revised_etd ? $row->revised_etd->format('Y-m-d') : '' }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm whitespace-nowrap" style="width: 150px;" data-field="eta">{{ $row->eta ? $row->eta->format('Y-m-d') : '' }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm whitespace-nowrap" style="width: 150px;" data-field="revised_eta">{{ $row->revised_eta ? $row->revised_eta->format('Y-m-d') : '' }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm whitespace-nowrap text-center" style="width: 120px;">
                                            <button onclick="event.stopPropagation(); deleteRow({{ $row->id }})" class="text-red-600 hover:text-red-800 inline-flex items-center justify-center" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="emptyRow">
                                        <td colspan="13" class="px-6 py-8 text-center text-gray-500 border border-gray-300">
                                            No rows added yet. Click "Add New Row" to get started.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .editing {
            background-color: #fef3c7 !important;
        }

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

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        /* Better input styling for edit mode */
        .editing input {
            padding: 0.5rem;
            font-size: 0.875rem;
        }

        /* Ensure table cells have proper spacing */
        #dataTable td, #dataTable th {
            border-color: #d1d5db;
        }
    </style>

    <script>
        const tableId = {{ $table->id }};
        const csrfToken = '{{ csrf_token() }}';

        function showMessage(message, type = 'success') {
            const container = document.getElementById('messageContainer');
            const bgColor = type === 'success' ? 'bg-green-50 border-green-500 text-green-800' : 'bg-red-50 border-red-500 text-red-800';
            const icon = type === 'success'
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';

            const messageDiv = document.createElement('div');
            messageDiv.className = `mb-4 ${bgColor} border-l-4 p-4 rounded-lg shadow-md animate-slide-in`;
            messageDiv.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${icon}
                    </svg>
                    <p class="text-sm">${message}</p>
                </div>
            `;

            container.innerHTML = '';
            container.appendChild(messageDiv);

            setTimeout(() => {
                messageDiv.style.opacity = '0';
                messageDiv.style.transform = 'translateY(-20px)';
                messageDiv.style.transition = 'all 0.3s';
                setTimeout(() => messageDiv.remove(), 300);
            }, 5000);
        }

        function addNewRow() {
            const emptyRow = document.getElementById('emptyRow');
            if (emptyRow) emptyRow.remove();

            const tbody = document.getElementById('tableBody');
            const rowCount = tbody.querySelectorAll('tr').length + 1;

            const newRow = document.createElement('tr');
            newRow.className = 'hover:bg-gray-50 editing';
            newRow.dataset.isNew = 'true';

            newRow.innerHTML = `
                <td class="px-6 py-4 border border-gray-300 text-sm whitespace-nowrap" style="width: 60px;">${rowCount}</td>
                <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 180px;" data-field="category"><input type="text" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" /></td>
                <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 180px;" data-field="part_no"><input type="text" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" /></td>
                <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 180px;" data-field="brand_name"><input type="text" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" /></td>
                <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 120px;" data-field="unit"><input type="text" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" /></td>
                <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 180px;" data-field="po_number"><input type="text" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" /></td>
                <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 150px;" data-field="vsl"><input type="text" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" /></td>
                <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 180px;" data-field="bl_num"><input type="text" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" /></td>
                <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 150px;" data-field="etd"><input type="date" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" /></td>
                <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 150px;" data-field="revised_etd"><input type="date" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" /></td>
                <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 150px;" data-field="eta"><input type="date" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" /></td>
                <td class="px-6 py-4 border border-gray-300 text-sm" style="width: 150px;" data-field="revised_eta"><input type="date" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" /></td>
                <td class="px-6 py-4 border border-gray-300 text-sm whitespace-nowrap text-center" style="width: 120px;">
                    <button onclick="saveRow(this)" class="text-green-600 hover:text-green-800 mr-2 inline-flex items-center" title="Save">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </button>
                    <button onclick="cancelEdit(this)" class="text-gray-600 hover:text-gray-800 inline-flex items-center" title="Cancel">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </td>
            `;

            tbody.appendChild(newRow);
            newRow.querySelector('input').focus();
        }

        function editRow(row) {
            if (row.classList.contains('editing')) return;

            const cells = row.querySelectorAll('td[data-field]');
            const originalData = {};

            cells.forEach(cell => {
                const field = cell.dataset.field;
                originalData[field] = cell.textContent.trim();

                const isDateField = ['etd', 'revised_etd', 'eta', 'revised_eta'].includes(field);
                const inputType = isDateField ? 'date' : 'text';

                cell.innerHTML = `<input type="${inputType}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="${originalData[field]}" />`;
            });

            row.dataset.originalData = JSON.stringify(originalData);
            row.classList.add('editing');

            // Change actions to save/cancel
            const actionsCell = row.querySelector('td:last-child');
            actionsCell.innerHTML = `
                <button onclick="saveRow(this)" class="text-green-600 hover:text-green-800 mr-2 inline-flex items-center" title="Save">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
                <button onclick="cancelEdit(this)" class="text-gray-600 hover:text-gray-800 inline-flex items-center" title="Cancel">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
        }

        async function saveRow(button) {
            const row = button.closest('tr');
            const isNew = row.dataset.isNew === 'true';
            const rowId = row.dataset.rowId;

            const data = {};
            const cells = row.querySelectorAll('td[data-field]');

            cells.forEach(cell => {
                const field = cell.dataset.field;
                const input = cell.querySelector('input');
                data[field] = input.value;
            });

            try {
                const url = isNew
                    ? `/tables/${tableId}/rows`
                    : `/tables/${tableId}/rows/${rowId}`;

                const method = isNew ? 'POST' : 'PUT';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    showMessage(result.message, 'success');

                    // Reload the page to refresh data
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showMessage(result.message, 'error');
                }
            } catch (error) {
                showMessage('Failed to save row: ' + error.message, 'error');
            }
        }

        function cancelEdit(button) {
            const row = button.closest('tr');

            if (row.dataset.isNew === 'true') {
                row.remove();

                // Check if table is empty and show empty message
                const tbody = document.getElementById('tableBody');
                if (tbody.children.length === 0) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.id = 'emptyRow';
                    emptyRow.innerHTML = `
                        <td colspan="13" class="px-6 py-8 text-center text-gray-500 border border-gray-300">
                            No rows added yet. Click "Add New Row" to get started.
                        </td>
                    `;
                    tbody.appendChild(emptyRow);
                }
                return;
            }

            const originalData = JSON.parse(row.dataset.originalData);
            const cells = row.querySelectorAll('td[data-field]');

            cells.forEach(cell => {
                const field = cell.dataset.field;
                cell.textContent = originalData[field];
            });

            row.classList.remove('editing');
            row.removeAttribute('ondblclick');
            row.setAttribute('ondblclick', 'editRow(this)');

            // Restore delete button
            const actionsCell = row.querySelector('td:last-child');
            const rowId = row.dataset.rowId;
            actionsCell.innerHTML = `
                <button onclick="event.stopPropagation(); deleteRow(${rowId})" class="text-red-600 hover:text-red-800 inline-flex items-center justify-center" title="Delete">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            `;
        }

        async function deleteRow(rowId) {
            if (!confirm('Are you sure you want to delete this row?')) {
                return;
            }

            try {
                const response = await fetch(`/tables/${tableId}/rows/${rowId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const result = await response.json();

                if (result.success) {
                    showMessage(result.message, 'success');

                    // Remove row from DOM
                    const row = document.querySelector(`tr[data-row-id="${rowId}"]`);
                    if (row) {
                        row.remove();
                    }

                    // Update row numbers
                    updateRowNumbers();

                    // Check if table is empty
                    const tbody = document.getElementById('tableBody');
                    if (tbody.children.length === 0) {
                        const emptyRow = document.createElement('tr');
                        emptyRow.id = 'emptyRow';
                        emptyRow.innerHTML = `
                            <td colspan="13" class="px-6 py-8 text-center text-gray-500 border border-gray-300">
                                No rows added yet. Click "Add New Row" to get started.
                            </td>
                        `;
                        tbody.appendChild(emptyRow);
                    }
                } else {
                    showMessage(result.message, 'error');
                }
            } catch (error) {
                showMessage('Failed to delete row: ' + error.message, 'error');
            }
        }

        function updateRowNumbers() {
            const tbody = document.getElementById('tableBody');
            const rows = tbody.querySelectorAll('tr:not(#emptyRow)');

            rows.forEach((row, index) => {
                const firstCell = row.querySelector('td:first-child');
                if (firstCell) {
                    firstCell.textContent = index + 1;
                }
            });
        }
    </script>
</x-app-layout>
