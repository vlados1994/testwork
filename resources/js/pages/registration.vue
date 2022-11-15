<template>
    <div class="container">
        <div class="row justify-content-center registration">
            <div class="registration__title">
                Регистрация
            </div>

            <v-form
                class="registration__form"
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
                                v-model="phone"
                                :rules="phoneRules"
                                label="Phone"
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
                                v-model="email"
                                :rules="emailRules"
                                label="E-mail"
                                required
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col
                            cols="12"
                            md="12"
                        >
                            <v-select
                                label="Тип"
                                v-model="type"
                                :rules="typeRules"
                                item-title="text"
                                item-value="value"
                                :items="[{ text: 'Пользователь', value: 'user' }, { text: 'Дантист', value: 'dentist' }]"
                            ></v-select>
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
                            class="mx-auto registration__btn"
                            max-width="220"
                        >
                            <v-btn
                                color="success"
                                @click="registration"
                            >
                                Зарегистрироваться
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
        phone: '',
        phoneRules: [
            v => !!v || 'Phone number is required',
        ],
        email: '',
        emailRules: [
            v => !!v || 'E-mail is required',
            v => /.+@.+/.test(v) || 'E-mail must be valid',
        ],
        password: '',
        passwordRules: [
            v => !!v || 'Password is required',
        ],
        type: '',
        typeRules: [
            v => !!v || 'Type is required',
        ],
    }),
    methods: {
        async registration() {
            if (!this.valid) {
                return false;
            }

            const response = await axios.post('/api/register', {
                name: this.fullName,
                phone: this.phone,
                email: this.email,
                password: this.password,
                type: this.type,
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
}
</script>

<style>
.registration {
    flex-direction: column;
    align-items: center;
}

.registration__title {
    width: auto;
    font-weight: bold;
    font-size: 20px;
    margin-top: 50px;
}

.registration__form {
    width: 500px;
    margin-top: 30px;
}

.registration__btn {
    margin-top: 30px;
}

</style>
