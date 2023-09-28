<script setup>
import LoginForm from "./login/loginForm.vue";
import RegisterForm from "./login/registerForm.vue";
import {ref} from 'vue';

const isLogin = ref(true);

    const toRegister = () => {
        isLogin.value = false;
    }
    const toLogin = () => {
        isLogin.value = true;
    }
</script>

<template>
    <div class="h-full relative max-xl:bg-gray-900 max-xl:px-2.5">
        <el-scrollbar>
            <div class="relative flex mx-auto h-screen">
                <div class="__left flex-1 bg-gray-800 relative p-8 max-xl:hidden">
                    <div class="flex items-center relative text-white">
                        <img src="../assets/logo.png"  alt="" class="w-12 h-12 mr-2.5">
                        <span class="text-xl font-bold">Laravel 骨架</span>
                    </div>
                    <div class="flex justify-center items-center text-center h-[calc(100%-48px)]">
                        <TransitionGroup appear tag="div" enter-active-class="animate__animated animate__bounceInLeft">
                            <img key="1" src="../assets/login-box-bg.svg" alt="" class="w-80">
                            <div key="2" class="text-3xl text-white">欢迎使用本系统</div>
                            <div key="3" class="mt-5 font-normal text-white text-base">开箱即用的中后台管理系统</div>
                        </TransitionGroup>
                    </div>
                </div>
                <div class="flex-1 p-8 max-sm:p-2.5 relative">
                    <div class="flex justify-between items-center text-white xl:justify-end">
                        <div class="flex items-center mx-auto xl:hidden">
                            <img src="../assets/logo.png"  alt="" class="w-12 h-12 mr-2.5">
                            <span class="text-xl font-bold">Laravel 骨架</span>
                        </div>
                    </div>
                    <Transition appear enter-active-class="animate__animated animate__bounceInRight">
                        <div class="h-full flex items-center m-auto w-full md:max-w-lg">
                            <LoginForm v-if="isLogin" @to-register="toRegister" class="p-5 h-auto m-auto lg:max-w-lg max-xl:rounded-3xl max-xl:bg-white" />
                            <RegisterForm v-else @to-login="toLogin" class="p-5 h-auto m-auto lg:max-w-lg max-xl:rounded-3xl max-xl:bg-white" />
                        </div>
                    </Transition>
                </div>
            </div>
        </el-scrollbar>
    </div>
</template>

<style scoped>
.__left:before {
    @apply absolute top-0 left-0 -z-10 w-full h-full bg-slate-900 bg-center bg-no-repeat
}
</style>
