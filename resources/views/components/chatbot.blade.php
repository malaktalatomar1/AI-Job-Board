<div
    style="
        position: fixed;
        right: 20px;
        bottom: 20px;
        z-index: 999999;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    "
>

    {{-- Chat Window --}}
    @if($open)

        <div
            style="
                width: min(92vw, 420px);
                height: 560px;
                max-height: 72vh;
                min-height: 320px;

                background: #0d1b2a;

                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 20px;

                box-shadow:
                    0 20px 60px rgba(0,0,0,0.45);

                overflow: hidden;

                margin-bottom: 12px;

                display: flex;
                flex-direction: column;
            "
        >

            {{-- Header --}}
            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;

                    padding: 16px 20px;

                    background: #f4b400;
                    color: #111827;

                    border-bottom: 1px solid rgba(0,0,0,0.1);
                "
            >

                <div
                    style="
                        display: flex;
                        align-items: center;
                        gap: 8px;

                        font-weight: 700;
                        font-size: 18px;
                    "
                >
                    <span>🤖</span>
                    <span>AI Assistant</span>
                </div>

                <button
                    type="button"
                    wire:click="toggleChat"
                    style="
                        font-size: 28px;
                        line-height: 1;

                        background: transparent;
                        border: none;

                        color: #111827;

                        cursor: pointer;
                    "
                >
                    ✕
                </button>

            </div>


            {{-- Messages --}}
            <div
                style="
                    flex: 1;

                    overflow-y: auto;

                    padding: 16px;

                    display: flex;
                    flex-direction: column;

                    gap: 12px;
                "
            >

                @if(empty($messages))

                    <div
                        style="
                            display: flex;
                            justify-content: flex-start;
                        "
                    >

                        <div
                            style="
                                background: rgba(255,255,255,0.08);

                                color: white;

                                border-radius: 16px;

                                padding: 12px 14px;

                                border: 1px solid rgba(255,255,255,0.1);

                                font-size: 16px;
                            "
                        >
                            Hello 👋
                        </div>

                    </div>

                @else

                    @foreach($messages as $message)

                        @if($message['role'] === 'user')

                            {{-- User Message --}}
                            <div
                                style="
                                    display: flex;
                                    justify-content: flex-end;
                                "
                            >

                                <div
                                    style="
                                        background: #f4b400;

                                        color: #111827;

                                        border-radius: 16px;

                                        padding: 12px 14px;

                                        max-width: 75%;

                                        font-weight: 500;

                                        word-break: break-word;
                                    "
                                >
                                    {{ $message['message'] }}
                                </div>

                            </div>

                        @else

                            {{-- AI Message --}}
                            <div
                                style="
                                    display: flex;
                                    justify-content: flex-start;
                                "
                            >

                                <div
                                    style="
                                        background: rgba(255,255,255,0.08);

                                        color: white;

                                        border-radius: 16px;

                                        padding: 12px 14px;

                                        max-width: 75%;

                                        border: 1px solid rgba(255,255,255,0.1);

                                        word-break: break-word;
                                    "
                                >
                                    {{ $message['message'] }}
                                </div>

                            </div>

                        @endif

                    @endforeach

                @endif

            </div>


            {{-- Input Area --}}
            <div
                style="
                    padding: 12px;

                    background: #111827;

                    border-top: 1px solid rgba(255,255,255,0.1);

                    display: flex;

                    gap: 8px;

                    align-items: center;
                "
            >

                <input
                    type="text"
                    wire:model.live="question"
                    wire:keydown.enter.prevent="ask"

                    placeholder="Ask anything..."

                    autocomplete="off"

                    style="
                        flex: 1;

                        min-width: 0;

                        border: 0;

                        border-radius: 12px;

                        background: #293344;

                        color: white;

                        padding: 12px 14px;

                        outline: none;

                        font-size: 16px;
                    "
                >

                <button
                    type="button"

                    wire:click="ask"

                    wire:loading.attr="disabled"
                    wire:target="ask"

                    style="
                        padding: 11px 18px;

                        border: 0;

                        border-radius: 12px;

                        background: #f4b400;

                        color: #111827;

                        font-weight: 700;

                        cursor: pointer;

                        font-size: 16px;

                        min-width: 80px;
                    "
                >

                    <span wire:loading.remove wire:target="ask">
                        Send
                    </span>

                    <span wire:loading wire:target="ask">
                        Sending...
                    </span>

                </button>

            </div>

        </div>

    @endif


    {{-- Floating Button --}}
    <button
        type="button"

        wire:click="toggleChat"

        style="
            width: 70px;
            height: 70px;

            min-width: 70px;
            min-height: 70px;

            border-radius: 50%;

            display: flex;

            align-items: center;
            justify-content: center;

            background:
                linear-gradient(
                    135deg,
                    #facc15,
                    #eab308
                );

            font-size: 32px;

            box-shadow:
                0 10px 30px
                rgba(244,180,0,0.55);

            border:
                3px solid
                rgba(255,255,255,0.3);

            cursor: pointer;

            color: #111827;

            position: relative;

            z-index: 999999;
        "
    >

        @if($open)

            ✕

        @else

            💬

        @endif

    </button>

</div>