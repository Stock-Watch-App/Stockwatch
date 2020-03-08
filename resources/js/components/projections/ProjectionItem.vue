<template>
    <div class="projection-card">
        <div class="hg-details">
            <h5>{{ houseguest.nickname }}</h5>
        </div>
        <div class="hg-img">
            <img :src="houseguestImage" :alt="houseguest.nickname">
        </div>
        <div class="this-week">
            <div class="this-week-details flex-col">
                <h5>This week</h5>
                <span class="rating-wrap">
                    <h5 class="num-wrap flex-row">
                        <font-awesome-icon icon="star" class="hg-star"/>
                        <span class="hg-star-rating">{{currentRating}}</span>
                        <span class="hg-star-outof"> /10</span>
                    </h5>
                </span> <span class="price-wrap">
                    <h5>{{ currentPrice | currency }}</h5>
                </span>
            </div>
        </div>

        <div class="next-week">
            <h5>Next Week</h5>
            <dl class="rating-table">
                <dt class="dt">Rating</dt>
                <dd>1</dd>
                <dd>2</dd>
                <dd>3</dd>
                <dd>4</dd>
                <dd>5</dd>
                <dd>6</dd>
                <dd>7</dd>
                <dd>8</dd>
                <dd>9</dd>
                <dd>10</dd>
                <dt class="dt">Price</dt>
                <dd :style="setbg(houseguest.projections.to1)">{{ houseguest.projections.to1 | currency }}</dd>
                <dd :style="setbg(houseguest.projections.to2)">{{ houseguest.projections.to2 | currency }}</dd>
                <dd :style="setbg(houseguest.projections.to3)">{{ houseguest.projections.to3 | currency }}</dd>
                <dd :style="setbg(houseguest.projections.to4)">{{ houseguest.projections.to4 | currency }}</dd>
                <dd :style="setbg(houseguest.projections.to5)">{{ houseguest.projections.to5 | currency }}</dd>
                <dd :style="setbg(houseguest.projections.to6)">{{ houseguest.projections.to6 | currency }}</dd>
                <dd :style="setbg(houseguest.projections.to7)">{{ houseguest.projections.to7 | currency }}</dd>
                <dd :style="setbg(houseguest.projections.to8)">{{ houseguest.projections.to8 | currency }}</dd>
                <dd :style="setbg(houseguest.projections.to9)">{{ houseguest.projections.to9 | currency }}</dd>
                <dd :style="setbg(houseguest.projections.to10)">{{ houseguest.projections.to10 | currency }}</dd>
            </dl>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            houseguest: Object
        },
        data() {
            return {
                //
            };
        },
        methods: {
            setbg: function (projections) {
                let red = '254,223,205,';
                let green = '208,251,227,';
                let alpha = Math.abs((projections / this.currentPrice) - 1);
                return {
                    'background-color': 'rgb(' + (((projections / this.currentPrice) > 1) ? green : red) + alpha + ')'
                }
            }
        },
        computed: {
            houseguestImage: function () {
                return '/storage' + this.houseguest.image;
            },
            currentPrice: function () {
                //find latest week
                let currentWeek;
                this.houseguest.prices.forEach(week => {
                    if (typeof currentWeek === 'undefined' || week.week > currentWeek.week) {
                        currentWeek = week;
                    }
                });

                this.$emit('current-price', {
                    houseguest: this.houseguest_id,
                    price: currentWeek.price
                });

                return currentWeek.price;
            },
            currentRating: function () {
                //find latest week
                let currentWeek = [];
                this.houseguest.ratings.forEach(week => {
                    if (typeof currentWeek[week.user_id] === 'undefined' || week.week > currentWeek[week.user_id].week) {
                        currentWeek[week.user_id] = week;
                    }
                });

                let total = 0;
                currentWeek.forEach(rating => {
                    total += rating.rating;
                });
                return Math.round(total / 4);
            },
        }
    };
</script>
