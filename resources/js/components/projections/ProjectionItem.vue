<template>
    <div class="projection-card">
        <div class="hg-details">
            <h5>{{ houseguest.nickname }}</h5>
        </div>
        <div class="hg-img">
            <img :src="houseguestImage" :alt="houseguest.nickname" />
        </div>
        <div class="this-week">
            <div class="this-week-details flex-col">
                <h5>This week</h5>
                <span class="rating-wrap">
                    <h5 class="num-wrap flex-row">
                        <font-awesome-icon icon="star" class="hg-star"/>
                        <span class="hg-star-rating">{{houseguest.current_rate}}</span>
                        <span class="hg-star-outof"> /10</span>
                    </h5>
                </span> <span class="price-wrap">
                    <h5>{{ houseguest.current_price | currency }}</h5>
                </span>
            </div>
        </div>

        <div class="next-week">
            <h5>Next Week</h5>
            <dl class="rating-table">
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
                <dd :style="setbg(houseguest.projections.to1)">{{ Math.round((houseguest.projections.to1/houseguest.current_price-1)*100) }}%</dd>
                <dd :style="setbg(houseguest.projections.to2)">{{ Math.round((houseguest.projections.to2/houseguest.current_price-1)*100) }}%</dd>
                <dd :style="setbg(houseguest.projections.to3)">{{ Math.round((houseguest.projections.to3/houseguest.current_price-1)*100) }}%</dd>
                <dd :style="setbg(houseguest.projections.to4)">{{ Math.round((houseguest.projections.to4/houseguest.current_price-1)*100) }}%</dd>
                <dd :style="setbg(houseguest.projections.to5)">{{ Math.round((houseguest.projections.to5/houseguest.current_price-1)*100) }}%</dd>
                <dd :style="setbg(houseguest.projections.to6)">{{ Math.round((houseguest.projections.to6/houseguest.current_price-1)*100) }}%</dd>
                <dd :style="setbg(houseguest.projections.to7)">{{ Math.round((houseguest.projections.to7/houseguest.current_price-1)*100) }}%</dd>
                <dd :style="setbg(houseguest.projections.to8)">{{ Math.round((houseguest.projections.to8/houseguest.current_price-1)*100) }}%</dd>
                <dd :style="setbg(houseguest.projections.to9)">{{ Math.round((houseguest.projections.to9/houseguest.current_price-1)*100) }}%</dd>
                <dd :style="setbg(houseguest.projections.to10)">{{ Math.round((houseguest.projections.to10/houseguest.current_price-1)*100) }}%</dd>
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
                let red = '235, 61, 61,';
                let green = '17,192,93,';
                let alpha = Math.abs((projections / this.houseguest.current_price) - 1);
                return {
                    'background-color': 'rgb(' + (((projections / this.houseguest.current_price) > 1) ? green : red) + alpha + ')'
                }
            }
        },
        computed: {
            houseguestImage: function () {
                return '/storage' + this.houseguest.image;
            },
        }
    };
</script>
