<template>
    <div>
        <ul class="flex">
            <li class="flex-grow cursor-pointer" v-for="tab in tabs"
                @click="selectTab(tab)"
                :href="tab.href"
                :key="tab.name">
                <a class="w-full inline-block py-2 px-4 font-semibold h-full rounded-t-lg border-l border-t border-r border-gray-500 no-underline"
                   :class="{
                        'bg-white text-blue-700 ': tab.isActive,
                        'bg-gray-300 text-blue-700 hover:bg-gray-100 border-b': tab.isActive === false
                   }"
                >{{ tab.name }}</a>
            </li>
        </ul>

        <div class="tabs-details border-b border-l border-r border-gray-500 px-2 py-4 bg-white">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        subgroup: {
            type: Boolean,
            default: false,
        },
        enablehash: {
            type: Boolean,
            default: false,
        }
    },
    data() {
        return {tabs: []};
    },
    created() {
        this.tabs = this.$children;
    },
    watch: {
        tabs: function () {
            if (location.hash !== '') {
                this.tabs.forEach(tab => {
                    tab.isActive = (tab.href === location.hash);
                });
            }
        }
    },
    methods: {
        selectTab(selectedTab) {
            if (this.enablehash) {
                location.hash = selectedTab.href
            }
            this.tabs.forEach(tab => {
                tab.isActive = (tab.href === selectedTab.href);
                // tab.isActive = (tab.name === selectedTab.name);
            });
        }
    }
}
</script>
