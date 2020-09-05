@extends('layouts.app')

@section('content')
    <div class="faq-wrap native-collapse-wrap mg-btm-md">
        <h3 class="mg-btm-lg">FAQs</h3>
        <details>
            <summary class="plus-icon">
                <span>What is the Stock Watch?</span>
            </summary>
                <p>The Stock Watch is a virtual stock market game for North American Big Brother shows</p>
        </details>
        <details>
            <summary class="plus-icon">
                <span>How does the Stock Watch work?</span>
            </summary>
                <p>Every week, the LFC (Taran, Brent, and Melissa) will rank the remaining houseguests. The average of these numbers, along with the audience ranking, will determine the price of each houseguest. You will then have the opportunity to purchase stock, betting on which houseguest you think will improve and do well in the game. Your goal is to accumulate as much net worth as you can. At the end of the season, the person with the most net worth will win the Stock Watch.</p>
        </details>
        <details>
            <summary class="plus-icon">
                <span>How are the stock prices determined?</span>
            </summary>
                <p>Magic, probably. We don’t actually know. Every day at 6am a little elf shows up with a scroll of numbers. We use that to set the prices for each houseguest.</p>

                <p>In all seriousness, we are using an algorithm that takes into account a houseguest’s current rating, as well as historical rating. A pattern of high ranks will result in a higher price, and vice versa for lower ranks.</p>
        </details>
        <details>
            <summary class="plus-icon">
                <span>How do I participate in the audience ratings?</span>
            </summary>
                <p>At some point in the 24 hours before the Roundtable for that week, Taran tweets out a survey for houseguest ratings. You can use that to contribute.</p>
        </details>
        <details>
            <summary class="plus-icon">
                <span>What’s the podcast schedule?</span>
            </summary>
            <p>Subject to change based on the Big Brother US 22 air dates and times:</p>
            <p>Live feed updates: 11AM ET daily</p>
            <p>Episode recaps: Thursday 9:15PM ET & Sunday 9:15PM ET</p>
            <p>Roundtable: Tuesday 9:30PM ET</p>
        </details>
        <details>
            <summary class="plus-icon">
                <span>When is the Stock Watch market opened and closed?</span>
            </summary>
            <p>The market will open Tuesday evening after the Roundtable and close Thursday night at 8pm ET</p>
        </details>
        <details>
            <summary class="plus-icon">
                <span>When can I buy and sell stocks?</span>
            </summary>
            <p>You can buy and sell stocks whenever the market is open, but you will be able to see your holdings at any time.</p>
        </details>
        <details>
            <summary class="plus-icon">
                <span>How do I report an issue with the Stock Watch?</span>
            </summary>
            <p>Please submit issues through the "report a bug" link in the lefthand sidebar</p>
        </details>
        <details>
            <summary class="plus-icon">
                <span>Can I sign in using my Reddit or Patreon account?</span>
            </summary>
            <p>Unfortunately Reddit and Patreon do not currently support this feature. Should this change in the future, we will include them as options.</p>
        </details>
    </div>
@endsection
