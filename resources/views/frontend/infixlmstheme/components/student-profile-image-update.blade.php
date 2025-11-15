<div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/solid.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/svg-with-js.min.css" rel="stylesheet"/>

    <style>
        .profilepic {
            position: relative;
            width: 272px;
            height: 272px;
            border-radius: 50%;
            overflow: hidden;
            background-color: #111;
            margin: auto;
            margin-bottom: 15px;
        }

        @media only screen and (min-width: 1581px) and (max-width: 1880px) {
            .profilepic {
                width: 200px;
                height: 200px;
            }
        }

        @media only screen and (min-width: 1440px) and (max-width: 1580px) {
            .profilepic {
                width: 200px;
                height: 200px;
            }
        }

        @media only screen and (min-width: 1200px) and (max-width: 1439px) {
            .profilepic {
                width: 200px;
                height: 200px;
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1199px) {
            .profilepic {
                width: 200px;
                height: 200px;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .profilepic {
                width: 160px;
                height: 160px;
            }
        }

        @media only screen and (max-width: 767px) {
            .profilepic {
                width: 150px;
                height: 150px;
            }
        }


        .profilepic:hover .profilepic__content {
            opacity: 1;
        }

        .profilepic:hover .profilepic__image {
            opacity: .5;
        }

        .profilepic__image {
            object-fit: cover;
            opacity: 1;
            transition: opacity .2s ease-in-out;
        }

        .profilepic__content {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            opacity: 0;
            transition: opacity .2s ease-in-out;
        }

        .profilepic__icon {
            color: white;
            padding-bottom: 8px;
        }

        .fas {
            font-size: 20px;
        }

        .profilepic__text {
            text-transform: uppercase;
            font-size: 12px;
            width: 50%;
            text-align: center;

        }

        .profilepic__text {
            position: absolute;
            bottom: 0;
            outline: none;
            color: transparent;
            width: 100%;
            box-sizing: border-box;
            padding: 150px 120px;
            cursor: pointer;
            transition: 0.5s;
            background: rgba(236, 231, 231, 0.5);
            opacity: 0;

        }

        .profilepic__text::-webkit-file-upload-button {
            visibility: hidden;
        }

        .profilepic__image {
            width: 100%;
            height: 100%
        }

    </style>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" value="{{route('ajaxUploadProfilePic')}}" id="ajax-update-profile-image">
        <input type="hidden" value="{{url('/')}}" id="url">
        <div class="profilepic">
            <img class="profilepic__image" src="{{getProfileImage($profile->image,$profile->name)}}"
                 id="show_profile_image"
                 width="272" height="272" alt="Profibild"/>
            <div class="profilepic__content">
                <span class="profilepic__icon"><i class="fas fa-camera"></i></span>
                <input type="file" id="pofile_image" title="" name="profile_pic" class="profilepic__text">
                <i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw  site_image_spinner" style="display: none"></i>
            </div>
        </div>
    </form>

</div>
