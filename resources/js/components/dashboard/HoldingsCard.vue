<template>
    <li class="card stockcard">
        <div class="hg-details">
            <h5>{{ houseguest.nickname || houseguest.first_name | capitalize }}</h5>
        </div>
        <div class="hg-img" >
            <img :src="houseguestImage(houseguest)" :alt="houseguest.nickname" />
        </div>
        <div class="user-holdings">
            <div>
                <span class="num">{{ stock.quantity }}</span><span class="word"> shares</span>
            </div>
            <div>
                <span class="num">{{ stock.quantity*houseguest.current_price | currency}}</span>
                <!-- <span class="word"> value</span> -->
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        props: {
            houseguests: Object,
            stock: Object,
        },
        data() {
            return {
                //
            }
        },
        methods: {
            houseguestImage: function (houseguest) {
                return '/storage' + houseguest.image;
            },
        },
        computed: {
            houseguest: function () {
                let houseguest;
                for (let hg of this.houseguests) {
                    if (hg.id === this.stock.houseguest_id) {
                        houseguest = hg;
                    }
                }
                return houseguest;
            }
        }
    }
</script>
