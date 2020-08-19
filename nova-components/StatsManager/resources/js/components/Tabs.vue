<template>
    <div>
        <ul>
            <li v-for="tab in tabs"
                @click="selectTab(tab)"
                :href="tab.href"
                :key="tab.name">
                <a :class="{
                        'active': tab.isActive,
                        'inactive': tab.isActive === false
                   }"
                >{{ tab.name }}</a>
            </li>
        </ul>

        <div class="tabs-details">
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
<style scoped>
    ul {
        display: flex;
        list-style: none;
        padding: 0;
    }

    li {
        flex-grow: 1;
        cursor: pointer;
    }

    a {
        width: 100%;
        display: inline-block;
        padding: .5rem 1rem;
        font-weight: 600;
        height: 100%;
        border-top-right-radius: 0.5rem;
        border-top-left-radius: 0.5rem;
        border: 1px solid #a0aec0;
        text-underline: none;
        color: #2b6cb0;
    }

    a.active {
        background-color: #ffffff;
        border-bottom-style: none;
    }

    a.inactive {
        background-color: #e2e8f0;;
    }

    a.inactive:hover {
        background-color: #edf2f7;
    }

    div.tabs-details {
        border: 1px solid #a0aec0;
        border-top: none;
        padding: .5rem 1rem;
        background-color: #ffffff;
    }
</style>
