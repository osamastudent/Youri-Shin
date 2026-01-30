@extends('companyAdmin.layouts.master')

@section('page-title')
Chat with {{ $customers->name }}
@endsection

@section('main-content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .container {
        max-width: 1170px;
        margin: auto;
    }

    img {
        max-width: 100%;
    }

    .inbox_people {
        background: #f8f8f8;
        float: left;
        overflow: hidden;
        width: 40%;
        border-right: 1px solid #c4c4c4;
    }

    .inbox_msg {
        border: 1px solid #c4c4c4;
        clear: both;
        overflow: hidden;
    }

    .top_spac {
        margin: 20px 0 0;
    }

    .recent_heading {
        float: left;
        width: 40%;
    }

    .srch_bar {
        display: inline-block;
        text-align: right;
        width: 60%;
    }

    .headind_srch {
        padding: 10px 29px 10px 20px;
        overflow: hidden;
        border-bottom: 1px solid #c4c4c4;
    }

    .recent_heading h4 {
        color: #05728f;
        font-size: 21px;
        margin: auto;
    }

    .srch_bar input {
        border: 1px solid #cdcdcd;
        border-width: 0 0 1px 0;
        width: 80%;
        padding: 2px 0 4px 6px;
        background: none;
    }

    .srch_bar .input-group-addon button {
        background: rgba(0, 0, 0, 0);
        border: medium none;
        padding: 0;
        color: #707070;
        font-size: 18px;
    }

    .srch_bar .input-group-addon {
        margin: 0 0 0 -27px;
    }

    .chat_ib h5 {
        font-size: 15px;
        color: #464646;
        margin: 0 0 8px 0;
    }

    .chat_ib h5 span {
        font-size: 13px;
        float: right;
    }

    .chat_ib p {
        font-size: 14px;
        color: #989898;
        margin: auto;
    }

    .chat_img {
        float: left;
        width: 11%;
    }

    .chat_ib {
        float: left;
        padding: 0 0 0 15px;
        width: 88%;
    }

    .chat_people {
        overflow: hidden;
        clear: both;
    }

    .chat_list {
        border-bottom: 1px solid #c4c4c4;
        margin: 0;
        padding: 18px 16px 10px;
    }

    .inbox_chat {
        height: 550px;
        overflow-y: scroll;
    }

    .active_chat {
        background: #ebebeb;
    }

    .incoming_msg_img {
        display: inline-block;
        width: 6%;
    }

    .received_msg {
        display: inline-block;
        padding: 0 0 0 10px;
        vertical-align: top;
        width: 92%;
    }

    .received_withd_msg p {
        background: #ebebeb;
        border-radius: 3px;
        color: #646464;
        font-size: 14px;
        margin: 0;
        padding: 5px 10px 5px 12px;
        width: 100%;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .time_date {
        color: #747474;
        display: block;
        font-size: 12px;
        margin: 8px 0 0;
    }

    .received_withd_msg {
        width: 57%;
    }

    .mesgs {
        padding: 30px 15px 0 25px;
        width: 100%;
    }

    .sent_msg p {
        background: #05728f;
        border-radius: 3px;
        font-size: 14px;
        margin: 0;
        color: #fff;
        padding: 5px 10px 5px 12px;
        width: 100%;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .outgoing_msg {
        overflow: hidden;
        margin: 26px 0 26px;
    }

    .sent_msg {
        float: right;
        width: 46%;
    }

    .input_msg_write input {
        background: rgba(0, 0, 0, 0);
        border: medium none;
        color: #4c4c4c;
        font-size: 15px;
        min-height: 48px;
        width: 100%;
    }

    .type_msg {
        border-top: 1px solid #c4c4c4;
        position: relative;
    }

    .msg_send_btn {
        background: #05728f;
        border: medium none;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        font-size: 17px;
        height: 40px;
        position: absolute;
        right: 0;
        top: 15px;
        width: 40px;
    }

    .messaging {
        padding: 0 0 50px 0;
    }

    .msg_history {
        background-color:#FFF;
        height: 500px;
        overflow-y: auto;
    }

    .right {
        float: right;
        clear: both;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .left {
        float: left;
        clear: both;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .file-input-wrapper {
        position: relative;
        display: inline-block;
    }

    .file-input-wrapper i {
        cursor: pointer;
    }

    .file-input {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
        width: 40px;
        height: 40px;
    }
</style>



<div class="container">
    <h3 class="text-center">Chat with {{ $customers->name }}</h3>
    <div class="messaging">
        <div class="inbox_msg">
            <div class="">
                <div class="msg_history" style="" id="chat-messages">
                    <!-- Messages will be displayed here -->
                </div>
                <div class="type_msg">
                    <div class="input_msg_write mx-2 mt-2">
                        <form id="" action="{{ route('customer-chat.send') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="to_user_id" value="{{ $customers->id }}">
                            <div class="d-flex align-items-center">
                                <div class="file-input-wrapper mr-2">
                                    <label for="file-input" class="file-label">
                                        <i class="fa-solid fa-paperclip fa-2xl"></i>
                                    </label>
                                    <input type="file" name="file" id="file-input" class="file-input">
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="message" class="write_msg flex-grow-1 ml-2" placeholder="Type a message" required>
                                <button class="msg_send_btn ml-2 align-self-center" type="submit"><i class="fa-solid fa-paper-plane"></i></button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="imagePreview" src="" alt="Image Preview" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    function fetchMessages() {
        $.ajax({
            url: '{{ route("customer-chat.show", $customers->id) }}',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                let messages = data.customerchats;
                let chatMessages = $('#chat-messages');
                chatMessages.empty();
                if (messages.length === 0) {
                    chatMessages.html('<div class="text-center" style="padding-top:10vw"><h3 class="text-danger">No messages yet</h3></div>');
                } else {
                    messages.forEach(function(message) {
                        let messageHtml = '';
                        if (message.message) {
                            messageHtml += `<p class="right mt-2 mx-2" style="background: #05728f;border-radius: 3px;font-size: 14px;margin: 0;color: #fff;padding: 5px 10px 5px 12px;width: 40%;">${message.message}</p>`;
                            if (message.file) {
                                messageHtml += `<img class="right img-thumbnail chat-image mx-2" style="height:40%" src="{{ asset('uploads/') }}/${message.file.trim()}" />`;
                            }
                            messageHtml += `<p class="right mx-2">${message.created_at}</p>`;
                        } else {
                            messageHtml += `<p class="left mt-2 mx-2" style="background: #05728f;border-radius: 3px;font-size: 14px;margin: 0;color: #fff;padding: 5px 10px 5px 12px;width: 40%;">${message.customer_message}</p>`;
                            if (message.file) {
                                messageHtml += `<img class="left img-thumbnail chat-image mx-2" style="height:40%" src="{{ asset('uploads/') }}/${message.file.trim()}" />`;
                            }
                            messageHtml += `<p class="left mx-2">${message.created_at}</p>`;
                        }
                        chatMessages.append(messageHtml);
                    });
                    scrollBottom();
                }
            }
        });
    }

    function scrollBottom() {
        var $chatHistory = $('.msg_history');
        $chatHistory.scrollTop($chatHistory[0].scrollHeight);
    }

    fetchMessages();

    setInterval(fetchMessages, 7000);

    $(document).on('click', '.chat-image', function() {
        var imgSrc = $(this).attr('src');
        $('#imagePreview').attr('src', imgSrc);
        $('#imageModal').modal('show');
    });
    $('#imageModal').on('click', '.close', function() {
        $('#imageModal').modal('hide');
    });

    $('#chatForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            enctype: 'multipart/form-data',
            success: function(response) {
                fetchMessages();
                $('input[name="message"]').val('');
                $('input[name="file"]').val('');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
});
</script>

@endsection