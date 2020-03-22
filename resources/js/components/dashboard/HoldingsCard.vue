<template>
    <li class="card stockcard">
        <div class="hg-details">
            <h5>{{ houseguest.nickname || houseguest.first_name | capitalize }}</h5>
            <p>{{ stock.quantity }} shares</p>
            <p>{{ stock.quantity*houseguest.current_price }} value</p>
        </div>
        <div class="hg-img" >
            <img :src="houseguestImage(houseguest)" :alt="houseguest.nickname" />
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
