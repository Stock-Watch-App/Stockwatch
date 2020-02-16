<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                    <t-input />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // export default {
    //     mounted() {
    //         console.log('Component mounted.')
    //     }
    // }

    import TInput from 'vue-tailwind/src/elements/TInput.vue'
        export default {
        components: {
            TInput
        }
    }
</script>
