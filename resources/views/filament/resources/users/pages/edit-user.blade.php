<!-- resources/views/filament/resources/users/pages/edit-user.blade.php -->
<div class="space-y-6">
    {{-- Filament edit form (default) --}}
    {{ $this->form }}

    {{-- Player Detail Card --}}
    @if($playerDetail)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">
                Player Details
            </h2>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gender</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $playerDetail->gender }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date of Birth</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $playerDetail->date_of_birth?->format('M d, Y') }}</dd>
                </div>
                <div class="col-span-2">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Contact Numbers</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                        Primary: {{ $playerDetail->personal_contact_number }}<br>
                        Alternative: {{ $playerDetail->alt_personal_contact_number }}
                    </dd>
                </div>
                <div class="col-span-2">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Emergency Contact</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                        {{ $playerDetail->emergency_contact_name }} ({{ $playerDetail->emergency_contact_relationship }}) – {{ $playerDetail->emergency_contact_number }}
                    </dd>
                </div>
            </dl>
        </div>
    @else
        <p class="text-sm text-gray-600 dark:text-gray-400">No player details found. You can add them via the profile page.</p>
    @endif
</div>
