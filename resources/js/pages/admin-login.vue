<template>
    <div class="container">
        <div class="row justify-content-center admin-login">
            <div class="admin-login__title">
                Админ-панель
            </div>

            <v-form
                class="admin-login__form"
                ref="form"
                v-model="valid"
            >
                <v-container>
                    <v-row>
                        <v-col
                            cols="12"
                            md="12"
                        >
                            <v-text-field
                                v-model="fullName"
                                :rules="nameRules"
                                label="Имя"
                                required
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col
                            cols="12"
                            md="12"
                        >
                            <v-text-field
                                label="Пароль"
                                v-model="password"
                                required
                                :rules="passwordRules"
                                :type="'password'"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-responsive
                            class="mx-auto admin-login__btn"
                            max-width="fit-content"
                        >
                            <v-btn
                                color="success"
                                @click="adminLogin"
                            >
                                Войти
                            </v-btn>
                        </v-responsive>
                    </v-row>
                </v-container>
            </v-form>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        valid: false,
        fullName: '',
        nameRules: [
            v => !!v || 'Name is required',
        ],
        password: '',
        passwordRules: [
            v => !!v || 'Password is required',
        ],
    }),
    methods: {
        async adminLogin() {
           if(this.fullName === 'admin' && this.password === 'admin') {
                this.$router.push({ name: 'admin' });
           }
        }
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>

<style>
.admin-login {
    flex-direction: column;
    align-items: center;
}

.admin-login__title {
    width: auto;
    font-weight: bold;
    font-size: 20px;
    margin-top: 50px;
}

.admin-login__form {
    width: 500px;
    margin-top: 30px;
}

.admin-login__btn {
    margin-top: 30px;
}

</style>
