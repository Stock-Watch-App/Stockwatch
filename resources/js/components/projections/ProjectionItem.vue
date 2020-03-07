<template>
<div class="projection-card">
                <div class="hg-details">
                    <h5>{{ houseguest.nickname }}</h5>
                </div>
                <div class="hg-img">
                    <img :src="houseguestImage" :alt="houseguest.nickname">
                </div>
                <div class="this-week">
                    <h5>This week</h5>
                    <span class="rating-wrap">
                        <h3 class="num-wrap flex-row">
                            <font-awesome-icon icon="star" class="hg-star"/>
                        </h3>
                            <span class="hg-star-rating">{{currentRating}}</span>
                            <span class="hg-star-outof"> /10</span>
                    </span>
                    <div class="price">$ {{currentPrice}}</div>
                </div>
                <!-- <div class="stock-value">
                    <h3>This Week</h3>
                    <div class="rating">Rating: {{$houseguest->current_rate}}</div>
                    <div class="price">$ {{$houseguest->current_price}}</div>
                </div> -->

                <div class="next-week">
                    <h5>Next Week</h5>
                    <table>
                        <tbody>
                        <tr>
                            <th>Rating:</th>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <th>Price:</th>
                            <td>{{ houseguest.projections.to1 | currency }}</td>
                            <td>{{ houseguest.projections.to2 | currency }}</td>
                            <td>{{ houseguest.projections.to3 | currency }}</td>
                            <td>{{ houseguest.projections.to4 | currency }}</td>
                            <td>{{ houseguest.projections.to5 | currency }}</td>
                            <td>{{ houseguest.projections.to6 | currency }}</td>
                            <td>{{ houseguest.projections.to7 | currency }}</td>
                            <td>{{ houseguest.projections.to8 | currency }}</td>
                            <td>{{ houseguest.projections.to9 | currency }}</td>
                            <td>{{ houseguest.projections.to10 | currency }}</td>
                        </tr>
                        </tbody>
                    </table>
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
    //
  },
        computed: {
            houseguestImage: function () {
              return '/storage'+this.houseguest.image;
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
