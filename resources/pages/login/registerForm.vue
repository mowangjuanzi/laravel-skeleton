<script setup>
import {ref} from "vue";
import {registerApi} from "../../api/session.js";
import {ElMessage} from "element-plus";
import "element-plus/es/components/message/style/css";

const formRef = ref();

/**
 * 表单数据
 * @type {{password: string, password_confirmation: string, username: string}}
 */
const formData = ref({
    name: "",
    mobile: "",
    password: "",
    password_confirmation: '',
})

/**
 * 表单验证
 */
const formRules = {
    name: [
        {
            required: true, message: "该项为必填项", trigger: "blur",
        }
    ],
    mobile: [
        {
            required: true, message: '该项为必填项', trigger: 'blur',
        },
        {
            type: "string", message: '必须是有效的手机号', len: 11, trigger: 'blur'
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
        },{
            validator: (rule, value, callback) => {
                if (value !== formData.value.password) {
                    callback(new Error('密码不匹配'));
                } else {
                    callback();
                }
            },
            trigger: 'blur',
        }
    ]
}

const submit = async (formEl) => {
    if (!formEl) {
        console.log('bbb');
        return false;
    }

    if (await formEl.validate()) {
        try {
            const res = await registerApi(formData.value);
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
    <el-form ref="formRef" :rules="formRules" hide-required-asterisk size="large" :model="formData" label-position="top">
        <el-row :gutter="20">
            <el-col :span="24">
                <el-form-item>
                    <h2 class="text-2xl font-bold text-center w-full">注册</h2>
                </el-form-item>
            </el-col>
            <el-col :span="24">
                <el-form-item label="昵称" prop="name">
                    <el-input name="name" v-model="formData.name" placeholder="请输入昵称"
                              clearable/>
                </el-form-item>
            </el-col>
            <el-col :span="24">
                <el-form-item label="手机号" prop="email">
                    <el-input name="mobile" v-model="formData.mobile" placeholder="请输入手机号"
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
                              v-model="formData.password_confirmation" placeholder="请输入密码" clearable/>
                </el-form-item>
            </el-col>
            <el-col :span="24">
                <el-form-item>
                    <div class="w-full">
                        <el-button type="primary" @click="submit(formRef)" class="w-full">注册</el-button>
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
