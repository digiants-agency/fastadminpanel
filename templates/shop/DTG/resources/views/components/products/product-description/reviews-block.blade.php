@if(sizeof($reviews))
    @foreach ($reviews as $review)
        <div class="review">
            <div class="review-header">
                <div class="review-icon-block">
                    <svg class="review-icon" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.3223 12.0426C13.9767 12.0426 15.4093 11.4492 16.5799 10.2785C17.7504 9.10793 18.3438 7.67571 18.3438 6.02109C18.3438 4.36705 17.7504 2.93463 16.5797 1.76372C15.4089 0.593374 13.9765 0 12.3223 0C10.6677 0 9.23543 0.593374 8.06489 1.76391C6.89435 2.93444 6.30078 4.36686 6.30078 6.02109C6.30078 7.67571 6.89435 9.10813 8.06508 10.2787C9.23581 11.449 10.6682 12.0426 12.3223 12.0426Z" fill="white"/>
                        <path d="M22.8579 19.2239C22.8241 18.7367 22.7558 18.2054 22.6553 17.6442C22.5538 17.0789 22.4232 16.5444 22.2668 16.056C22.1052 15.5511 21.8855 15.0525 21.6139 14.5747C21.332 14.0788 21.0009 13.647 20.6293 13.2917C20.2408 12.9199 19.7651 12.621 19.215 12.403C18.6668 12.1862 18.0593 12.0763 17.4095 12.0763C17.1543 12.0763 16.9075 12.181 16.4309 12.4913C16.1375 12.6826 15.7944 12.9039 15.4114 13.1486C15.0839 13.3573 14.6402 13.5528 14.0923 13.7298C13.5576 13.9028 13.0148 13.9905 12.479 13.9905C11.9432 13.9905 11.4006 13.9028 10.8654 13.7298C10.318 13.553 9.87434 13.3575 9.54723 13.1488C9.16786 12.9064 8.82454 12.6851 8.5268 12.4911C8.05073 12.1808 7.80373 12.0761 7.54852 12.0761C6.8985 12.0761 6.2912 12.1862 5.74322 12.4032C5.19352 12.6208 4.71764 12.9197 4.32873 13.2919C3.95737 13.6474 3.62606 14.079 3.34454 14.5747C3.07312 15.0525 2.85339 15.5509 2.69165 16.0562C2.53544 16.5446 2.40479 17.0789 2.30331 17.6442C2.2028 18.2046 2.13451 18.7362 2.10075 19.2244C2.06757 19.7028 2.05078 20.1993 2.05078 20.7007C2.05078 22.0057 2.46563 23.0622 3.28369 23.8414C4.09164 24.6102 5.16071 25.0003 6.46076 25.0003H18.4984C19.7985 25.0003 20.8672 24.6104 21.6753 23.8414C22.4936 23.0628 22.9084 22.0061 22.9084 20.7005C22.9082 20.1968 22.8912 19.6999 22.8579 19.2239Z" fill="white"/>
                        <clipPath id="clip0_104_2438">
                        <rect width="25" height="25" fill="white"/>
                        </clipPath>
                    </svg>
                </div>
                <div class="review-header-desc">
                    <div class="review-name">{{ $review->name }}</div>
                    <div class="extra-text color-grey review-date">{{ date_format( date_create($review->created_at), 'd.m.Y') }}</div>
                </div>
            </div>
            <div class="extra-text color-text review-text">
                {{ $review->message }}
            </div>
        </div>
        @if(!empty($review->answer))
            <div class="review-answer">
                <div class="review-answer-header">
                    <div class="review-name review-answer-name">{{ $fields['review_answer'] }}</div>
                    <div class="extra-text color-grey review-date">{{ date_format( date_create($review->updated_at), 'd.m.Y') }}</div>
                </div>
                <div class="extra-text color-text review-answer-text">{{ $review->answer }}</div>
            </div>
        @endif
    @endforeach
@else
    <div class="main-text color-text">{{ $fields['reviews_none'] }}</div>
@endif

@desktopcss
<style>

    .review {
        background: var(--color-back-and-stroke);
        border-radius: 6px;
        padding: 20px;
        width: 611px;
        margin-bottom: 20px;
    }

    .review-header {
        display: flex;
        margin-bottom: 20px;
    }

    .review-icon-block {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        background-color: var(--color-second);
        border-radius: 50%;
    }

    .review-icon {
        width: 25px;
        height: 25px;
    }

    .review-name {
        font-style: normal;
        font-weight: 450;
        font-size: 18px;
        line-height: 28px;
    }

    .review-answer{
        margin-left: 20px;
        border-left: 4px solid var(--color-second);
        padding-left: 15px;
        margin-bottom: 42px;
    }

    .review-answer-header {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

    .review-answer-name {
        margin-right: 10px;
    }

</style>
@mobilecss
<style>

    .reviews {
        width: 100%;
    }

    .review {
        background: var(--color-back-and-stroke);
        border-radius: 6px;
        padding: 17px 15px;
        margin-bottom: 15px;
        width: 100%;
    }

    .review-header {
        display: flex;
        margin-bottom: 8px;
    }

    .review-icon-block {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        background-color: var(--color-second);
        border-radius: 50%;
    }

    .review-icon {
        width: 16px;
        height: 16px;
    }

    .review-name {
        font-style: normal;
        font-weight: 450;
        font-size: 14px;
        line-height: 18px;
    }

    .review-answer{
        margin-left: 15px;
        border-left: 3px solid var(--color-second);
        padding-left: 9px;
        margin-bottom: 25px;
    }

    .review-answer-header {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .review-answer-name {
        margin-right: 10px;
    }

</style>
@endcss