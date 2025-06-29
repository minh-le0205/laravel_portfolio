<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit About Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Biography -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium mb-2">
                                Biography
                            </label>
                            <textarea id="biography" name="biography" rows="6"
                                class="block w-full rounded-lg border-[#6366F1] focus:border-[#6366F1] focus:ring-[#6366F1]" required>{{ old('biography', $about->biography) }}</textarea>
                            @error('biography')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Skills -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium mb-2">
                                Skills
                            </label>
                            <div id="skills-container" class="space-y-3">
                                @forelse(old('skills', $about->skills ?? []) as $skill)
                                    <div class="flex gap-3">
                                        <input type="text" name="skills[]" value="{{ $skill }}"
                                            class="block w-full rounded-lg border-[#6366F1] focus:border-[#6366F1] focus:ring-[#6366F1]"
                                            required>
                                        <button type="button" onclick="removeSkill(this)"
                                            class="px-4 py-2 bg-[#EF4444] text-white rounded-lg hover:bg-red-600">
                                            Remove
                                        </button>
                                    </div>
                                @empty
                                    <div class="flex gap-3">
                                        <input type="text" name="skills[]"
                                            class="block w-full rounded-lg border-[#6366F1] focus:border-[#6366F1] focus:ring-[#6366F1]"
                                            required>
                                        <button type="button" onclick="removeSkill(this)"
                                            class="px-4 py-2 bg-[#EF4444] text-white rounded-lg hover:bg-red-600">
                                            Remove
                                        </button>
                                    </div>
                                @endforelse
                            </div>
                            <button type="button" onclick="addSkill()"
                                class="mt-3 px-4 py-2 bg-[#6366F1] text-white rounded-lg hover:bg-[#4F46E5]">
                                Add Skill
                            </button>
                            @error('skills')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Resume -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium mb-2">
                                Resume
                            </label>
                            @if ($about->resume_path)
                                <div class="flex items-center gap-4 mb-4">
                                    <a href="{{ Storage::url($about->resume_path) }}" target="_blank"
                                        class="text-[#6366F1] hover:text-[#4F46E5]">
                                        View Current Resume
                                    </a>
                                    <form action="{{ route('admin.about.delete-resume') }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[#EF4444] hover:text-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                            <div class="flex gap-3 items-center">
                                <label
                                    class="block px-4 py-2 bg-[#6366F1] text-white rounded-lg hover:bg-[#4F46E5] cursor-pointer">
                                    Choose File
                                    <input type="file" name="resume" accept=".pdf,.doc,.docx" class="hidden">
                                </label>
                                <span class="text-sm text-gray-500" id="file-name">No file chosen</span>
                            </div>
                            @error('resume')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end mt-8">
                            <button type="submit"
                                class="px-4 py-2 bg-[#6366F1] text-white rounded-lg hover:bg-[#4F46E5]">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            console.log('About page scripts loaded!');

            // Make sure DOM is loaded
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM Content Loaded');
                // Initialize file input handler
                const fileInput = document.querySelector('input[type="file"]');
                if (fileInput) {
                    fileInput.addEventListener('change', function(e) {
                        const fileName = e.target.files[0]?.name || 'No file chosen';
                        const fileNameElement = document.getElementById('file-name');
                        if (fileNameElement) {
                            fileNameElement.textContent = fileName;
                        }
                    });
                }

                // Initialize skills container
                initializeSkills();
            });

            function initializeSkills() {
                const container = document.getElementById('skills-container');
                if (!container) {
                    console.error('Skills container not found');
                    return;
                }

                // Ensure at least one skill input exists
                if (container.children.length === 0) {
                    addSkill();
                }
            }

            function addSkill() {
                const container = document.getElementById('skills-container');
                if (!container) {
                    console.error('Skills container not found');
                    return;
                }

                const skillInput = document.createElement('div');
                skillInput.className = 'flex gap-3 opacity-0 transform translate-y-3';
                skillInput.innerHTML = `
                    <input type="text"
                        name="skills[]"
                        class="block w-full rounded-lg border-[#6366F1] focus:border-[#6366F1] focus:ring-[#6366F1]"
                        required
                        placeholder="Enter a skill">
                    <button type="button"
                        onclick="removeSkill(this)"
                        class="px-4 py-2 bg-[#EF4444] text-white rounded-lg hover:bg-red-600 transition duration-150">
                        Remove
                    </button>
                `;
                container.appendChild(skillInput);

                // Trigger reflow for animation
                skillInput.offsetHeight;

                // Add animation classes
                skillInput.classList.add('transition-all', 'duration-300', 'ease-out');
                requestAnimationFrame(() => {
                    skillInput.classList.remove('opacity-0', 'translate-y-3');
                });

                // Focus the new input
                const input = skillInput.querySelector('input');
                if (input) {
                    input.focus();
                }
            }

            function removeSkill(button) {
                const container = document.getElementById('skills-container');
                if (!container) return;

                const skillDiv = button.closest('.flex');
                if (!skillDiv) return;

                if (container.children.length > 1) {
                    // Add animation classes
                    skillDiv.classList.add('transition-all', 'duration-300', 'ease-out', 'opacity-0', 'transform',
                        'translate-y-3');

                    // Remove after animation
                    setTimeout(() => {
                        skillDiv.remove();
                    }, 300);
                } else {
                    // If it's the last skill, just clear the input
                    const input = skillDiv.querySelector('input');
                    if (input) {
                        input.value = '';
                        input.focus();
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
