<template>
    <label :style="cssProps" class="switch relative inline-block">
        <input class="hidden" type="checkbox" id="togBtn" v-model="checkbox" @change="$emit('toggled', checkbox)">
        <div class="slider rounded-full absolute cursor-pointer"></div>
    </label>
</template>

<script>
    export default {
        props: {
            checkbox: {
                type: Boolean,
                default: false
            },
            labels: Object,
        },
        computed: {
            cssProps() {
                return {
                    '--label-false': "'"+this.labels.false+"'",
                    '--label-true': "'"+this.labels.true+"'",
                }
            }
        }
    }
</script>

<style scoped>
    .switch {
        width: 90px;
        height: 34px;
    }

    .slider {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ca2222;
        -webkit-transition: .4s;
        transition: .4s;
        box-shadow: inset 0 0 3px #000;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 50%;
        box-shadow: 0 0 3px 0 #000;
    }

    input:checked + .slider {
        background-color: #2ab934;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(55px);
    }

    /*------ ADDED CSS ---------*/
    .slider:after {
        content: var(--label-false);
        color: white;
        display: block;
        position: absolute;
        font-weight: bold;
        transition: .4s;
        top: 35%;
        right: 10%;
        font-size: 10px;
        font-family: Verdana, sans-serif;
    }

    input:checked + .slider:after {
        content: var(--label-true);
        right: auto;
        left: 10%;
    }

    /*--------- END --------*/
</style>
