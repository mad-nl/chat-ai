<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MAD NL | CHAT AI</title>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>

<body>
    <header class="bg-white">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <div class="-m-1.5 p-1.5">
                    <span class="sr-only">MAD NL</span>
                    <img class="h-16 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo">
                </div>
            </div>
        </nav>
    </header>

    <div class="h-screen flex flex-col">
        <div class="bg-gray-50 flex-1 flex flex-col">
            <div class="messages px-4 py-2 flex-1 overflow-y-auto">
                <!-- Chat messages will appear here -->
            </div>
        </div>
        <div class="bg-gray-100 px-4 py-2">
            <form id="chat-form">
                <div class="flex items-center">
                    <input class="w-full border rounded-full py-2 px-4 mr-2" type="text" name="message"
                        id="message" placeholder="Type your message...">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-full">
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer class="w-full bg-white">
        <div class="px-8 py-12 mx-auto max-w-7xl">
            <div
                class="flex flex-col justify-between text-center pt-10 mt-10 border-t border-gray-100 md:flex-row md:items-center">
                <p class="mb-6 text-sm text-left text-gray-600 md:mb-0">© Copyright
                    <script>
                        document.write(new Date().getFullYear());
                    </script>. All Rights Reserved. | Mady by <a href="https://madnl.nl" target="_blank"
                        class="text-blue-500">MAD NL</a>
                </p>
            </div>
        </div>
    </footer>

    <script>
        $(document).ready(function() {
            $("#chat-form").submit(function(event) {
                event.preventDefault();

                var messageInput = $("#message");
                var messageText = messageInput.val().trim();

                if (messageText === '') {
                    return;
                }

                messageInput.prop('disabled', true);
                $("button").prop('disabled', true);

                $.ajax({
                    url: "{{ route('chat') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        "model": "gpt-3.5-turbo",
                        "content": messageText
                    },
                    success: function(res) {
                        $(".messages").append(
                            '<div class="bg-blue-500 text-white rounded-lg p-2 shadow mr-2 max-w-sm mb-4 right-message ml-auto"><span class="font-medium">You: </span>' +
                            '<p>' + messageText + '</p></div>'
                        );

                        $(".messages").append(
                            '<div class="bg-white rounded-lg p-2 shadow mb-2 max-w-sm left-message text-left"><p><span class="font-medium">Ai: </span>' +
                            '<p>' + res + '</p></div>'
                        );

                        $(".messages").scrollTop($(".messages")[0].scrollHeight);

                        messageInput.val('');
                        messageInput.prop('disabled', false);
                        $("button").prop('disabled', false);
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                        messageInput.prop('disabled', false);
                        $("button").prop('disabled', false);
                    }
                });
            });
        });
    </script>
</body>

</html>
