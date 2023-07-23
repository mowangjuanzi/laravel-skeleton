<script setup>
import {reactive} from "vue";

const formData = reactive({
    username: "",
    password: "",
    password_confirmation: '',
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
    password_confirmation: [
        {
            required: true, message: "该项为必填项", trigger: "blur",
        }
    ]
});
</script>

<template>
    <el-form :rules="rules" hide-required-asterisk size="large" :model="formData"
             label-position="top" class="p-5 h-auto m-auto max-xl:rounded-3xl max-xl:bg-white">
        <el-row :gutter="20">
            <el-col :span="24">
                <el-form-item>
                    <h2 class="text-2xl font-bold text-center w-full">注册</h2>
                </el-form-item>
            </el-col>
            <el-col :span="24">
                <el-form-item label="用户名" prop="username">
                    <el-input name="username" v-model="formData.username" placeholder="请输入用户名"
                              clearable/>
                </el-form-item>
            </el-col>
            <el-col :span="24">
                <el-form-item label="密码" prop="password">
                    <el-input :input-style="{width: '100%'}" type="password" show-password
                              v-model="formData.password" placeholder="请输入密码" clearable/>
                </el-form-item>
            </el-col>
            <el-col :span="24">
                <el-form-item label="确认密码" prop="password_confirmation">
                    <el-input :input-style="{width: '100%'}" type="password" show-password
                              v-model="formData.password" placeholder="请输入密码" clearable/>
                </el-form-item>
            </el-col>
            <el-col :span="24">
                <el-form-item>
                    <div class="w-full">
                        <el-button type="primary" class="w-full">注册</el-button>
                    </div>
                    <div class="w-full">
                        <el-button type="default" class="w-full mt-4" @click="$emit('toLogin')">已有账号？去登录
                        </el-button>
                    </div>
                </el-form-item>
            </el-col>
        </el-row>
    </el-form>
</template>

<style scoped>

</style>
