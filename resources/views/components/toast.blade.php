@php
    $messages = [];

    if (session('success')) {
        $messages[] = ['type' => 'success', 'message' => session('success')];
    }
    if (session('error')) {
        $messages[] = ['type' => 'error', 'message' => session('error')];
    }
    if (session('warning')) {
        $messages[] = ['type' => 'warning', 'message' => session('warning')];
    }
@endphp

@if (count($messages) > 0)
    <div
        x-data="toastManager"
        data-toasts="{{ Js::from($messages) }}"
        class="pointer-events-none fixed bottom-6 right-6 z-50 flex flex-col-reverse gap-3 sm:max-w-sm"
        aria-live="polite"
        aria-label="Notifications"
    >
        <template x-for="(toast, index) in toasts" :key="index">
            <div
                x-init="setTimeout(() => remove(index), 5000)"
                x-transition:enter="transform transition duration-300 ease-out"
                x-transition:enter-start="translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transform transition duration-200 ease-in"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="translate-x-full opacity-0"
                class="pointer-events-auto flex items-start gap-3 rounded-xl border p-4 shadow-lg backdrop-blur-sm"
                :class="{
                    'border-emerald-200 bg-emerald-50 dark:border-emerald-800 dark:bg-emerald-900/50': toast.type === 'success',
                    'border-red-200 bg-red-50 dark:border-red-800 dark:bg-red-900/50': toast.type === 'error',
                    'border-amber-200 bg-amber-50 dark:border-amber-800 dark:bg-amber-900/50': toast.type === 'warning',
                }"
                role="alert"
            >
                <div class="flex-shrink-0 pt-0.5">
                    <template x-if="toast.type === 'success'">
                        <svg class="h-5 w-5 text-emerald-500 dark:text-emerald-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                        </svg>
                    </template>
                    <template x-if="toast.type === 'error'">
                        <svg class="h-5 w-5 text-red-500 dark:text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
                        </svg>
                    </template>
                    <template x-if="toast.type === 'warning'">
                        <svg class="h-5 w-5 text-amber-500 dark:text-amber-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                        </svg>
                    </template>
                </div>

                <p
                    class="flex-1 text-sm font-medium"
                    :class="{
                        'text-emerald-800 dark:text-emerald-200': toast.type === 'success',
                        'text-red-800 dark:text-red-200': toast.type === 'error',
                        'text-amber-800 dark:text-amber-200': toast.type === 'warning',
                    }"
                    x-text="toast.message"
                ></p>

                <button
                    @click="remove(index)"
                    class="flex-shrink-0 rounded-md p-1 transition-colors"
                    :class="{
                        'text-emerald-500 hover:bg-emerald-100 hover:text-emerald-700 dark:text-emerald-400 dark:hover:bg-emerald-800': toast.type === 'success',
                        'text-red-500 hover:bg-red-100 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-800': toast.type === 'error',
                        'text-amber-500 hover:bg-amber-100 hover:text-amber-700 dark:text-amber-400 dark:hover:bg-amber-800': toast.type === 'warning',
                    }"
                    aria-label="Dismiss notification"
                >
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
                    </svg>
                </button>
            </div>
        </template>
    </div>
@endif
