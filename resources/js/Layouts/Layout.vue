<template>
    <q-layout view="hHh lpR fFf" class="bg-grey-1">
        <q-header elevated class="bg-white text-grey-8" height-hint="64">
            <q-toolbar class="GNL__toolbar">
                <q-btn flat dense round @click="toggleLeftDrawer" aria-label="Menu" icon="menu" class="q-mr-sm" />

                <q-toolbar-title v-if="$q.screen.gt.xs" shrink class="row items-center no-wrap">
                    <img src="https://cdn.quasar.dev/img/layout-gallery/logo-google.svg">
                    <span class="q-ml-sm">News</span>
                </q-toolbar-title>

                <q-space />
                <q-space />

                <div class="q-gutter-sm row items-center no-wrap">
                    <q-btn v-if="$q.screen.gt.sm" round dense flat color="text-grey-7" icon="apps">
                        <q-tooltip>Google Apps</q-tooltip>
                    </q-btn>
                    <q-btn round dense flat color="grey-8" icon="notifications">
                        <q-badge color="red" text-color="white" floating>
                            2
                        </q-badge>
                        <q-tooltip>Notifications</q-tooltip>
                    </q-btn>
                    <q-btn-dropdown round flat rounded>
                        <template v-slot:label>
                            <q-avatar size="26px">
                                <img :src="avatar">
                            </q-avatar>
                        </template>
                        <q-list>
                            <q-item clickable v-close-popup @click="router.get('/user/profile')">
                                <q-item-section>
                                    <q-item-label> {{ $page.props.auth.user.name }}</q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-item clickable v-close-popup @click="logout">
                                <q-item-section>
                                    <q-item-label>Logout</q-item-label>
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </q-btn-dropdown>
                </div>
            </q-toolbar>
        </q-header>

        <q-drawer v-model="leftDrawerOpen" show-if-above bordered class="bg-white" :width="280">


            <q-list padding class="text-grey-8" style="margin-top: 150px;">
                <q-item class="GNL__drawer-item" v-ripple v-for="link in links1" :key="link.text" clickable
                    @click="router.get(link.url)">
                    <q-item-section avatar>
                        <q-icon :name="link.icon" />
                    </q-item-section>
                    <q-item-section>
                        <q-item-label>{{ link.text }}</q-item-label>
                    </q-item-section>

                </q-item>

                <q-separator inset class="q-my-sm" />

                <q-item class="GNL__drawer-item" v-ripple v-for="link in links2" :key="link.text" clickable>
                    <q-item-section avatar>
                        <q-icon :name="link.icon" />
                    </q-item-section>
                    <q-item-section>
                        <q-item-label>{{ link.text }}</q-item-label>
                    </q-item-section>
                </q-item>

                <q-separator inset class="q-my-sm" />

                <!-- <q-item class="GNL__drawer-item" v-ripple v-for="link in links3" :key="link.text" clickable>
                    <q-item-section>
                        <q-item-label>{{ link.text }} <q-icon v-if="link.icon" :name="link.icon" /></q-item-label>
                    </q-item-section>
                </q-item> -->

                <!-- <div class="q-mt-md">
                    <div class="flex flex-center q-gutter-xs">
                        <a class="GNL__drawer-footer-link" href="javascript:void(0)" aria-label="Privacy">Privacy</a>
                        <span> · </span>
                        <a class="GNL__drawer-footer-link" href="javascript:void(0)" aria-label="Terms">Terms</a>
                        <span> · </span>
                        <a class="GNL__drawer-footer-link" href="javascript:void(0)" aria-label="About">About
                            Google</a>
                    </div>
                </div> -->
            </q-list>
            <q-img class="absolute-top" src="https://cdn.quasar.dev/img/material.png" style="height: 150px">
                <div class="absolute-bottom bg-transparent">
                    <q-avatar size="56px" class="q-mb-sm">
                        <img :src="avatar">
                    </q-avatar>
                    <div class="text-weight-bold">{{ $page.props.auth.user.name }}</div>
                    <div>{{ $page.props.auth.user.email }}</div>
                </div>
            </q-img>
        </q-drawer>


        <q-page-container>
            <slot></slot>
        </q-page-container>
    </q-layout>
</template>
<script lang="ts" setup>
import { ref } from 'vue'
import { fasEarthAmericas, fasFlask } from '@quasar/extras/fontawesome-v6'
import { router, usePage} from '@inertiajs/vue3';
const page = usePage();
const avatar = page.props.auth.user.avatar
console.log(page.props.auth.user.avatar)


const leftDrawerOpen = ref(false)
const search = ref('')
const showAdvanced = ref(false)
const showDateOptions = ref(false)
const exactPhrase = ref('')
const hasWords = ref('')
const excludeWords = ref('')
const byWebsite = ref('')
const byDate = ref('Any time')

const links1 = [
    { icon: 'web', text: 'Dashboard', url: '/dashboard' },
    { icon: fasEarthAmericas, text: 'My Forum' },
    { icon: 'person', text: 'Friends', url: '/user/profile' },
    { icon: 'star_border', text: 'Favourites' },
    { icon: 'search', text: 'Saved searches' }
]
const links2 = [
    { icon: 'flag', text: 'Boomarks' },
    { icon: 'place', text: 'Language & region' },
    // { icon: 'domain', text: 'Business' },
    // { icon: 'memory', text: 'Technology' },
    // { icon: 'local_movies', text: 'Entertainment' },
    // { icon: 'directions_bike', text: 'Sports' },
    // { icon: fasFlask, text: 'Science' },
    // { icon: 'fitness_center', text: 'Health ' }
]
const links3 = [
    { icon: '', text: 'Settings' },
    { icon: '', text: 'Logout' },

]


const onClear = () => {
    exactPhrase.value = ''
    hasWords.value = ''
    excludeWords.value = ''
    byWebsite.value = ''
    byDate.value = 'Any time'
}

const changeDate = (option) => {
    byDate.value = option
    showDateOptions.value = false
}

const toggleLeftDrawer = () => {
    leftDrawerOpen.value = !leftDrawerOpen.value
}

const logout = () => {
    router.post(route('logout'));
};

</script>


<style lang="sass">
.GNL
    &__toolbar
      height: 64px
  
    &__toolbar-input
      width: 55%
  
    &__drawer-item
      line-height: 24px
      border-radius: 0 24px 24px 0
      margin-right: 12px
  
      .q-item__section--avatar
        .q-icon
          color: #5f6368
  
      .q-item__label
        color: #3c4043
        letter-spacing: .01785714em
        font-size: .875rem
        font-weight: 500
        line-height: 1.25rem
  
    &__drawer-footer-link
      color: inherit
      text-decoration: none
      font-weight: 500
      font-size: .75rem
  
      &:hover
        color: #000
  </style>