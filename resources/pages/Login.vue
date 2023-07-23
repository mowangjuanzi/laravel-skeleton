<script setup>
import LoginForm from "./auth/components/loginForm.vue";

import {reactive} from "vue";

const formData = reactive({
    username: "",
    password: "",
    remember: false,
});

/**
 * 验证规则
 */
const rules = reactive({
    username: [
        {
            required: true, message: "该项为必填项", trigger: "blur",
        }
    ],
    password: [
        {
            required: true, message: "该项为必填项", trigger: "blur",
        }
    ],
});

</script>

<template>
    <div class="h-full relative max-xl:bg-slate-800 max-xl:px-2.5">
        <div class="relative h-full flex mx-auto">
            <div class="flex-1 bg-gray-700 relative p-[30px] max-xl:hidden">
                <div class="flex items-center relative text-white">
                    <img src="../images/logo.png" alt="" class="w-12 h-12 mr-2.5"/>
                    <span class="text-xl font-bold">ElementAdmin</span>
                </div>
                <div class="flex justify-center items-center h-[calc(100%-60px)]">
                    <TransitionGroup appear tag="div">
                        <img src="../images/login-box-bg.svg" key="1" alt="" class="w-[350px]"/>
                        <div class="text-3xl text-center text-white" key="2">欢迎使用本系统</div>
                        <div class="mt-5 font-normal text-white text-center text-sm" key="3">
                            开箱即用的中后台管理系统
                        </div>
                    </TransitionGroup>
                </div>
            </div>
            <div class="flex-1 p-[30px] max-sm:p-2.5 relative">
                <div class="flex justify-between items-center text-white 2xl:justify-end xl:justify-end">
                    <div class="flex items-center 2xl:hidden xl:hidden">
                        <img src="../images/logo.png" alt="" class="w-12 h-12 mr-2.5">
                        <span class="text-xl font-bold">ElementAdmin</span>
                    </div>
                </div>
                <Transition appear class="v-enter-active">
                    <div
                        class="h-full flex items-center m-auto w-full 2xl:max-w-[500px] xl:max-w-[500px] md:max-w-[500px] lg:max-w-[500px]">
                        <LoginForm/>
                    </div>
                </Transition>
            </div>
        </div>
    </div>
</template>

<style scoped>
.el-form .el-row {
    margin-right: 0 !important;
    margin-left: 0 !important;
}
</style>
