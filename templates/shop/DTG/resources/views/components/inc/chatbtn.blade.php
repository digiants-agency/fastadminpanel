<div class="chatbtns" id="chatbtns">
    <div class="mainbtn">
        <svg class="open" width="34" height="30" viewBox="0 0 34 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M21.7984 0.740967H3.29032C1.47605 0.740967 0 2.21702 0 4.03129V14.5877C0 16.402 1.47605 17.8781 3.29032 17.8781H5.51081L5.01644 21.1412C4.91581 21.8056 5.43136 22.4023 6.10094 22.4023C6.48845 22.4023 5.90743 22.6503 14.8872 17.8781H21.7984C23.6127 17.8781 25.0887 16.402 25.0887 14.5877V4.03129C25.0887 2.21695 23.6127 0.740967 21.7984 0.740967ZM6.375 11.2289C5.31668 11.2289 4.45565 10.3678 4.45565 9.30951C4.45565 8.2512 5.31668 7.39016 6.375 7.39016C7.43332 7.39016 8.29436 8.2512 8.29436 9.30951C8.29436 10.3678 7.43332 11.2289 6.375 11.2289ZM12.5444 11.2289C11.486 11.2289 10.625 10.3678 10.625 9.30951C10.625 8.2512 11.486 7.39016 12.5444 7.39016C13.6027 7.39016 14.4637 8.2512 14.4637 9.30951C14.4637 10.3678 13.6027 11.2289 12.5444 11.2289ZM18.7137 11.2289C17.6554 11.2289 16.7944 10.3678 16.7944 9.30951C16.7944 8.2512 17.6554 7.39016 18.7137 7.39016C19.772 7.39016 20.6331 8.2512 20.6331 9.30951C20.6331 10.3678 19.772 11.2289 18.7137 11.2289ZM34 10.8861V21.4426C34 23.2598 32.5269 24.7329 30.7097 24.7329H28.4894L28.9836 27.9958C29.0842 28.6566 28.5725 29.2571 27.8992 29.2571C27.5091 29.2571 28.0748 29.4959 19.1127 24.7329H12.2016C11.379 24.7329 10.6258 24.4294 10.0482 23.9286C9.48113 23.4367 9.56367 22.5333 10.2108 22.1529C15.1748 19.2358 14.9098 19.3244 15.3215 19.3244H22.4578C24.593 19.3244 26.324 17.5935 26.324 15.4583V8.69258C26.324 8.08682 26.815 7.59581 27.4207 7.59581H30.7097C32.5269 7.59581 34 9.06891 34 10.8861Z"
                fill="white"/>
        </svg>
        <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M11.1044 10.0008L19.7707 1.33445C20.0758 1.02934 20.0758 0.534648 19.7707 0.22957C19.4656 -0.0755078 18.9709 -0.0755469 18.6658 0.22957L9.9995 8.8959L1.33323 0.22957C1.02811 -0.0755469 0.533427 -0.0755469 0.228349 0.22957C-0.0767284 0.534687 -0.0767674 1.02937 0.228349 1.33445L8.89462 10.0007L0.228349 18.6671C-0.0767674 18.9722 -0.0767674 19.4669 0.228349 19.7719C0.380888 19.9245 0.580848 20.0007 0.780809 20.0007C0.98077 20.0007 1.18069 19.9245 1.33327 19.7719L9.9995 11.1057L18.6658 19.7719C18.8183 19.9245 19.0183 20.0007 19.2182 20.0007C19.4182 20.0007 19.6181 19.9245 19.7707 19.7719C20.0758 19.4668 20.0758 18.9721 19.7707 18.6671L11.1044 10.0008Z"
                fill="white"/>
        </svg>
    </div>
    <div class="alllinks">
        @foreach ($fields['social'] as $social_item)
            <a rel="nofollow" target="_blank" href="{{ $social_item[0] }}">
                <img src="{{ $social_item[3] }}" alt="">
                <span>{{ $social_item[4] }}</span>
            </a>
		@endforeach
    </div>
</div>

@desktopcss

<style>

    
    /* messengers */

    .chatbtns {
        position: fixed;
        right: 80px;
        bottom: 40px;
        z-index: 99999;
    }

    .chatbtns .alllinks {
        position: absolute;
        right: 60px;
        width: 0;
        bottom: -20px;
        display: flex;
        transition: .5s;
    }

    .chatbtns .alllinks.active {
        width: 350px;
    }

    .chatbtns .alllinks a {
        display: flex;
        position: relative;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-style: normal;
        font-weight: normal;
        font-size: 16px;
        line-height: 21px;
        margin: 0 5px;
        color: var(--main-color);
        width: 90px;
        height: 90px;
    }

    .chatbtns .alllinks a span {
        position: absolute;
        bottom: -15px;
        display: block;
        padding: 2px 10px;
        border-radius: 5px;
        font-size: 14px;
        line-height: 21px;
        background-color: #FFFFFF;
        opacity: 0;
        transition: .5s;
    }

    .chatbtns .alllinks a img {
        width: 90px;
        /* height: 90px; */
        transition: .3s;
    }

    .chatbtns .alllinks a img:hover {
        transform: scale(1.2);
    }

    .chatbtns .alllinks a:hover span {
        opacity: .75;
    }

    .chatbtns .mainbtn {
        width: 50px;
        height: 50px;
        background: var(--color-second);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .chatbtns .mainbtn img {
        width: 20px;
        height: 20px;
    }

    .chatbtns .mainbtn:before {
        position: absolute;
        top: -5px;
        left: -5px;
        width: 60px;
        height: 60px;
        background: var(--color-second);
        display: block;
        content: '';
        border-radius: 50%;
        z-index: -1;
        box-shadow: var(--color-back-and-stroke) 0 0 20px;
        animation: animbtn 2s linear infinite;
    }

    .chatbtns .mainbtn svg {
        width: 30px;
        height: 30px;
    }

    .chatbtns .mainbtn.active svg.close {
        display: block;
        width: 20px;
        height: 20px;
    }

    .chatbtns .mainbtn.active svg.open {
        display: none;
    }

    .chatbtns .mainbtn svg.close {
        display: none;
    }

    @keyframes animbtn {
        0 {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }

    .chatbtns .mainbtn:after {
        position: absolute;
        top: -10px;
        left: -10px;
        width: 70px;
        height: 70px;
        background: var(--color-light-blue), 50%;
        display: block;
        content: '';
        border-radius: 50%;
        z-index: -1;
        animation: animbtn 2s linear infinite;
    }


</style>

@mobilecss

<style>

        
    .chatbtns {
        position: fixed;
        right: 20px;
        bottom: 20px;
        z-index: 99999;
    }

    .chatbtns .alllinks {
        position: absolute;
        bottom: 60px;
        padding: 5px;
        right: -12px;
        height: 0;
        display: flex;
        flex-direction: column;
        opacity: 0;
        pointer-events: none;
        transition: .5s;
        align-items: flex-end;
    }

    .chatbtns .alllinks.active {
        pointer-events: initial;
        opacity: 1;
        height: 300px;
    }

    .chatbtns .alllinks a {
        display: flex;
        align-items: center;
        font-style: normal;
        font-weight: normal;
        font-size: 16px;
        line-height: 21px;
        color: var(--color-second);
        margin: 3px 0;
        width: 50px;
        height: 50px;
    }

    .chatbtns .alllinks a span {
        display: none;
    }

    .chatbtns .alllinks a img {
        width: 50px;
        height: 50px;
    }

    .chatbtns .mainbtn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .chatbtns .mainbtn img {
        width: 15px;
        height: 15px;
    }

    .chatbtns .mainbtn:before {
        position: absolute;
        top: -5px;
        left: -5px;
        width: 50px;
        height: 50px;
        background: var(--color-second);
        box-shadow:  var(--color-back-and-stroke) 0 0 20px;
        display: block;
        content: '';
        border-radius: 50%;
        z-index: -1;
        animation: animbtn 2s linear infinite;
    }

    .chatbtns .mainbtn svg {
        width: 20px;
        height: 20px;
    }

    .chatbtns .mainbtn.active svg.close {
        display: block;
        width: 15px;
        height: 15px;
    }

    .chatbtns .mainbtn.active svg.open {
        display: none;
    }

    .chatbtns .mainbtn svg.close {
        display: none;
    }

    @keyframes animbtn {
        0 {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }

    .chatbtns .mainbtn:after {
        position: absolute;
        top: -10px;
        left: -10px;
        width: 60px;
        height: 60px;
        background: var(--color-light-blue),
        display: block;
        content: '';
        border-radius: 50%;
        z-index: -1;
        animation: animbtn 2s linear infinite;
    }

</style>

@endcss

@js

<script>

    if (document.querySelector(".chatbtns .mainbtn")) {


        document.querySelector(".chatbtns .mainbtn").addEventListener('click',function(){
            
            document.querySelector(".chatbtns .mainbtn").classList.toggle('active')
            document.querySelector('.chatbtns .alllinks').classList.toggle('active')
            
            if (!is_mobile) {
                
                if (!document.querySelector(".alllinks").hasAttribute('style')) {
                    count_elements = document.querySelector(".alllinks").children.length
                    widthPxBlock = document.querySelector(".chatbtns .mainbtn").offsetWidth
                    widthScreen = document.querySelector("body").offsetWidth
                    width = widthPxBlock/widthScreen*100*count_elements + 1.6*count_elements
                    document.querySelector('.chatbtns .alllinks').style = "width: "+width+"vw"

                } else {
                    document.querySelector(".alllinks").removeAttribute('style')
                }

            } else {

                if (!document.querySelector(".alllinks").hasAttribute('style')) {

                    count_elements = document.querySelector(".alllinks").children.length
                    heightPxBlock = document.querySelector(".chatbtns .mainbtn").offsetHeight
                    heightScreen = window.innerHeight
                    console.log(count_elements, heightPxBlock, heightScreen)
                    height = heightPxBlock/heightScreen*100*(1.25*count_elements)
                    document.querySelector('.chatbtns .alllinks').style = "height: calc("+height+"vh + "+(6 * count_elements)+"px)"

                } else {
                    document.querySelector(".alllinks").removeAttribute('style')
                }
            }
        })
    }


</script>

@endjs