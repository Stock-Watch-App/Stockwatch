import Vue from "vue";

// save our state (isPanel open or not) 
export const store = Vue.observable({
    isActive: true
});

// We call toggleNav anywhere we need it in our app
export const mutations = {
    toggleNavbarMobile() {
        store.isActive = !store.isActive
    }
};