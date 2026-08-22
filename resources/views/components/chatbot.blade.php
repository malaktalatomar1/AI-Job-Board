<div>

    @php
        // هل الصفحة الحالية داخل Filament Admin؟
        $isFilament = request()->is('admin') || request()->is('admin/*');
    @endphp


    {{-- Floating Chat Container --}}
    <div
        class="
            fixed
            z-[99999]
            flex
            flex-col
            items-center
            {{ $isFilament
                ? 'bottom-24 left-6'
                : 'bottom-6 right-6'
            }}
        "
    >

        {{-- Chat Window --}}
        @if($open)

            <div
                class="
                    mb-4
                    {{ $isFilament ? 'w-[430px] h-[600px]' : 'w-[380px] h-[520px]' }}
                    max-w-[90vw]
                    bg-white
                    rounded-2xl
                    shadow-2xl
                    overflow-hidden
                    flex
                    flex-col
                    border
                    border-gray-200
                "
            >

                {{-- Header --}}
                <div
                    class="
                        flex
                        items-center
                        justify-between
                        px-5
                        py-4
                        bg-gradient-to-r
                        from-indigo-600
                        to-blue-600
                        text-white
                    "
                >

                    <div class="flex items-center gap-3 font-bold text-lg">

                        <div
                            class="
                                w-9
                                h-9
                                rounded-full
                                bg-white/20
                                flex
                                items-center
                                justify-center
                            "
                        >
                            🤖
                        </div>

                        <div>
                            <div class="text-base">
                                AI Assistant
                            </div>

                            <div class="text-xs font-normal text-white/80">
                                AI Job Board
                            </div>
                        </div>

                    </div>


                    <button
                        type="button"
                        wire:click="toggleChat"
                        class="
                            w-8
                            h-8
                            rounded-full
                            flex
                            items-center
                            justify-center
                            bg-white/10
                            hover:bg-white/20
                            hover:scale-110
                            transition
                            text-lg
                        "
                    >
                        ✕
                    </button>

                </div>


                {{-- Messages --}}
                <div
                    class="
                        flex-1
                        overflow-y-auto
                        p-4
                        space-y-4
                        bg-gray-50
                    "
                >

                    @if(empty($messages))

                        {{-- Welcome Message --}}
                        <div class="flex justify-start">

                            <div class="flex items-start gap-2">

                                <div
                                    class="
                                        w-8
                                        h-8
                                        rounded-full
                                        bg-indigo-100
                                        flex
                                        items-center
                                        justify-center
                                        text-sm
                                        flex-shrink-0
                                    "
                                >
                                    🤖
                                </div>

                                <div
                                    class="
                                        bg-white
                                        text-gray-700
                                        rounded-2xl
                                        rounded-tl-sm
                                        px-4
                                        py-3
                                        border
                                        border-gray-200
                                        shadow-sm
                                        max-w-[75%]
                                    "
                                >
                                    Hello 👋
                                    <br>
                                    <span class="text-sm text-gray-500">
                                        How can I help you today?
                                    </span>
                                </div>

                            </div>

                        </div>

                    @else

                        @foreach($messages as $message)

                            {{-- User Message --}}
                            @if($message['role'] === 'user')

                                <div class="flex justify-end">

                                    <div
                                        class="
                                            bg-gradient-to-r
                                            from-indigo-600
                                            to-blue-600
                                            text-white
                                            rounded-2xl
                                            rounded-tr-sm
                                            px-4
                                            py-3
                                            max-w-[75%]
                                            break-words
                                            shadow-sm
                                        "
                                    >
                                        {{ $message['message'] }}
                                    </div>

                                </div>

                            @else

                                {{-- AI Message --}}
                                <div class="flex justify-start">

                                    <div class="flex items-start gap-2">

                                        <div
                                            class="
                                                w-8
                                                h-8
                                                rounded-full
                                                bg-indigo-100
                                                flex
                                                items-center
                                                justify-center
                                                text-sm
                                                flex-shrink-0
                                            "
                                        >
                                            🤖
                                        </div>

                                        <div
                                            class="
                                                bg-white
                                                text-gray-700
                                                rounded-2xl
                                                rounded-tl-sm
                                                px-4
                                                py-3
                                                max-w-[75%]
                                                border
                                                border-gray-200
                                                shadow-sm
                                                break-words
                                            "
                                        >
                                            {{ $message['message'] }}
                                        </div>

                                    </div>

                                </div>

                            @endif

                        @endforeach

                    @endif

                </div>


                {{-- Input --}}
                <div
                    class="
                        p-3
                        bg-white
                        border-t
                        border-gray-200
                        flex
                        gap-2
                    "
                >

                    <input
                        type="text"
                        wire:model.live="question"
                        wire:keydown.enter.prevent="ask"
                        placeholder="Ask anything..."
                        autocomplete="off"
                        class="
                            flex-1
                            min-w-0
                            rounded-xl
                            border
                            border-gray-200
                            bg-gray-50
                            text-gray-800
                            placeholder-gray-400
                            px-4
                            py-3
                            focus:border-indigo-500
                            focus:ring-2
                            focus:ring-indigo-500/20
                            outline-none
                            transition
                        "
                    >


                    <button
                        type="button"
                        wire:click="ask"
                        wire:loading.attr="disabled"
                        wire:target="ask"
                        class="
                            px-5
                            rounded-xl
                            bg-gradient-to-r
                            from-indigo-600
                            to-blue-600
                            text-white
                            font-semibold
                            hover:from-indigo-700
                            hover:to-blue-700
                            transition
                            shadow-sm
                        "
                    >

                        <span
                            wire:loading.remove
                            wire:target="ask"
                        >
                            Send
                        </span>

                        <span
                            wire:loading
                            wire:target="ask"
                        >
                            ...
                        </span>

                    </button>

                </div>

            </div>

        @endif


        {{-- Floating Button --}}
        <button
            type="button"
            wire:click="toggleChat"
            class="
                {{ $isFilament
                    ? 'w-20 h-20 text-4xl'
                    : 'w-16 h-16 text-3xl'
                }}
                flex
                items-center
                justify-center
                rounded-full
                bg-gradient-to-br
                from-indigo-600
                to-blue-600
                text-white
                shadow-xl
                shadow-indigo-500/30
                hover:scale-110
                hover:shadow-2xl
                transition
                duration-200
                border-4
                border-white
            "
        >

            @if($open)

                ✕

            @else

                🤖

            @endif

        </button>

    </div>

</div>