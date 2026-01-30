@extends('companyAdmin.layouts.master')

@section('page-title')
    Company Profile
@endsection

@section('main-content')
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            overflow-x: hidden; 
        }
        .container {
            margin-top: 50px;
            padding-bottom: 100px;
            display: flex;
        }
        .page-title {
            font-family: 'Georgia', serif;
            color: #333;
            margin-bottom: 40px;
            display: flex;
        }
        .page-title span {
            display: inline-block;
            opacity: 0;
            animation: bounceIn 0.6s forwards;
        }
        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            60% {
                transform: scale(1.2);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        .profile-details {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            border: 1px solid #dee2e6;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s ease-in-out forwards;
            animation-delay: 1s;
            flex: 1;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .profile-details p {
            font-size: 18px;
            margin-bottom: 10px;
            color: #555;
            opacity: 0;
            animation: fadeIn 1s ease-in-out forwards;
        }
        .profile-details .col-md-6:nth-child(1) p:nth-child(1) { animation-delay: 1.2s; }
        .profile-details .col-md-6:nth-child(1) p:nth-child(2) { animation-delay: 1.4s; }
        .profile-details .col-md-6:nth-child(1) p:nth-child(3) { animation-delay: 1.6s; }
        .profile-details .col-md-6:nth-child(2) p:nth-child(1) { animation-delay: 1.8s; }
        .profile-details .col-md-6:nth-child(2) p:nth-child(2) { animation-delay: 2s; }
        .profile-details .col-md-6:nth-child(2) p:nth-child(3) { animation-delay: 2.2s; }
        .profile-details .row:nth-child(2) .col-md-6:nth-child(1) p { animation-delay: 2.4s; }
        .profile-details .row:nth-child(2) .col-md-6:nth-child(2) p { animation-delay: 2.6s; }
        .profile-details p strong {
            font-weight: 600;
            color: #000;
        }
        .background-video {
            position: relative;
            width: 50%;
            overflow: hidden;
        }
        .background-video video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

    <div class="container">
        <div class="profile-details">
            <div class="page-title" id="company-title">
                <h1>
                    <strong>
                        <span>C</span><span>o</span><span>m</span><span>p</span><span>a</span><span>n</span><span>y</span>
                        <span> </span>
                        <span>P</span><span>r</span><span>o</span><span>f</span><span>i</span><span>l</span><span>e</span>
                    </strong>
                </h1>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <img src="/uploads/{{ $user->logo_img }}" width="200"  class="rounded-pill img-thumbnail">
                    <br><br>
                    <p><strong>Company Name:</strong><br>{{ $user->name }}</p>
                    <p><strong>Contact Number:</strong><br>{{ $user->contact_number }}</p>
                    <p><strong>Address:</strong><br>{{ $user->address }}</p>
                    <p><strong>Email:</strong><br>{{ $user->email }}</p>
                    <p><strong>Referral Code:</strong><br>{{ $user->refrel_code }}</p>
                </div>
            </div>
        </div>
        <!--<div class="background-video">-->
        <!--    <video autoplay loop muted>-->
        <!--        <source src="/dist/water.mp4" type="video/mp4">-->
        <!--    </video>-->
        <!--</div>-->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const letters = document.querySelectorAll('.page-title span');
            letters.forEach((letter, index) => {
                letter.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
@endsection
