<template>
    <div class="container">
        <div class="row justify-content-center login">
            <div class="login__title">
                Вход
            </div>

            <v-form
                class="login__form"
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
                            class="mx-auto login__btn"
                            max-width="fit-content"
                        >
                            <v-btn
                                color="success"
                                @click="login"
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
        async login() {
            if (!this.valid) {
                return false;
            }

            const response = await axios.post('/api/login', {
                name: this.fullName,
                password: this.password,
            });

            const type = response.data.data.type;

            if (response.data.success) {
                localStorage.setItem('authtoken', response.data.data.token)

                axios.interceptors.request.use(
                    (config) => {
                        const token = localStorage.getItem('authtoken');

                        if (token) {
                            config.headers['Authorization'] = `Bearer ${token}`;
                        }

                        return config;
                    },
                    (error) => {
                        return Promise.reject(error);
                    }
                );

                if (type === 'user') {
                    this.$router.push({ name: 'user-page' });
                } else {
                    this.$router.push({ name: 'dentist-page' });
                }
            }
        }
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>

<style>
.login {
    flex-direction: column;
    align-items: center;
}

.login__title {
    width: auto;
    font-weight: bold;
    font-size: 20px;
    margin-top: 50px;
}

.login__form {
    width: 500px;
    margin-top: 30px;
}

.login__btn {
    margin-top: 30px;
}

</style>
