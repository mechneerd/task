<script setup>
import { useForm,Link } from '@inertiajs/vue3';

const register_form = useForm({
    'name':null,
   'email':null,
   'password':null,
   'password_confirmation':null,
})
defineProps({
  layout: false
});
const register = () =>{
   // console.log(register_form);
    register_form.post('/register',{
        preserveScroll: true,
        onError: () => register_form.reset('password','password_confirmation'),
    });
}

 </script>

<template>
    <section class="bg-gray-50 dark:bg-gray-900">
      <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
          <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
              <img class="w-8 h-8 mr-2" src="/storage/app/public/logos/school-management-logo.svg" alt="logo">
                  
          </a>
          <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
              <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                  <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                      Sign up
                  </h1>
                  <form class="space-y-4 md:space-y-6" @submit.prevent="register">
                <IconField>
                    <InputIcon class="pi pi-user" />
                    <InputText class="w-full" v-model="register_form.name" placeholder="Name" />
                </IconField>
                <div v-if="register_form.errors.name">{{ register_form.errors.name }}</div>

                <IconField>
                    <InputIcon class="pi pi-inbox" />
                    <InputText class="w-full" v-model="register_form.email" placeholder="Email" />
                </IconField>
                <div v-if="register_form.errors.email">{{ register_form.errors.email }}</div>

                <IconField>
                    <InputIcon class="pi pi-key" />
                    <InputText class="w-full" type="password" v-model="register_form.password" placeholder="Password" />
                </IconField>
                <div v-if="register_form.errors.password">{{ register_form.errors.password }}</div>
                

                <IconField>
                    <InputIcon class="pi pi-key" />
                    <InputText class="w-full" type="password" v-model="register_form.password_confirmation" placeholder="Re-enter Password" />
                </IconField>
                <div v-if="register_form.errors.password_confirmation">{{ register_form.errors.password_confirmation }}</div>

                      <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign Up</button>
                      <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Already have an account yet? 
                        <Link href="/" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign in
                        </Link>
                      </p>
                  </form>
              </div>
          </div>
      </div>
    </section>
    </template>
    

    
    <style>
    
    </style>