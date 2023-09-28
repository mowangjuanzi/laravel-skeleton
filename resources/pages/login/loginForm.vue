<script setup>
import {ref} from "vue";
import {loginApi} from "../../api/session.js";
import {ElMessage} from "element-plus";
import {useRouter} from "vue-router";

const formRef = ref();

const {push} = useRouter();

/**
 * 表单数据
 */
const formData = ref({
    mobile: "",
    password: "",
    remember: false,
});

/**
 * 表单验证
 */
const formRules = {
    mobile: [
        {
            required: true, message: "该项为必填项", trigger: "blur",
        }
    ],
    password: [
        {
            required: true, message: "该项为必填项", trigger: "blur",
        }
    ],
};

const submit = async (formEl) => {
    if (!formEl) {
        console.log('bbb');
        return false;
    }

    if (await formEl.validate()) {
        try {
            const res = await loginApi(formData.value);

            if (formData.value.remember) {
                localStorage.setItem('token', res.data.token);
            } else {
                sessionStorage.setItem('token', res.data.token);
            }

            push({path: "/"});
        } catch (e) {
            ElMessage({
                message: e.response.data.message || '',
                type: "error",
            })
        }
    }
};
</script>

<template>
    <el-form ref="formRef" :model="formData" hide-required-asterisk :rules="formRules" size="large" label-position="top">
        <el-row :gutter="20">
            <el-col :span="24">
                <el-form-item>
                    <h2 class="text-2xl font-bold text-center w-full">登录</h2>
                </el-form-item>
            </el-col>
            <el-col :span="24">
                <el-form-item label="手机号" prop="mobile">
                    <el-input name="mobile" v-model="formData.mobile" placeholder="请输入用户名"
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
                <el-form-item>
                    <div class="flex justify-between items-center w-full">
                        <el-checkbox v-model="formData.remember" label="记住我" size="small"/>
                        <el-link type="primary" :underline="false">忘记密码</el-link>
                    </div>
                </el-form-item>
            </el-col>
            <el-col :span="24">
                <el-form-item>
                    <div class="w-full">
                        <el-button type="primary" @click="submit(formRef)" class="w-full">登录</el-button>
                    </div>
                    <div class="w-full mt-4">
                        <el-button type="default" class="w-full" @click="$emit('toRegister')">注册</el-button>
                    </div>
                </el-form-item>
            </el-col>
        </el-row>
    </el-form>
</template>

<style scoped>

</style>
