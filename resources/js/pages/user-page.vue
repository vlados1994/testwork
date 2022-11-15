<template>
    <div class="container">
        <div class="row justify-content-center appointment">
            <div class="appointment__title">
                Запись на прием к дантисту
            </div>
            <v-form
                class="appointment__form"
                ref="form"
                v-model="valid"
            >
                <v-container>
                    <v-row>
                        <v-col
                            cols="12"
                            md="12"
                        >
                            <v-select
                                label="Специалист"
                                v-model="dentist"
                                :rules="dentistRules"
                                item-title="name"
                                item-value="id"
                                :items="dentists"
                            ></v-select>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col
                            cols="12"
                            md="12"
                        >
                            <v-select
                                label="Услуга"
                                v-model="service"
                                :rules="serviceRules"
                                item-title="name"
                                item-value="id"
                                :items="services"
                            ></v-select>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col
                            cols="12"
                            md="12"
                        >
                            <Datepicker v-model="date"/>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-responsive
                            class="mx-auto appointment__btn"
                            max-width="220"
                        >
                            <v-btn
                                color="success"
                                @click="makeAnAppointment"
                            >
                                Записаться на прием
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
        dentist: '',
        dentists: [],
        dentistRules: [
            v => !!v || 'Dentist is required',
        ],
        service: '',
        services: [
            {id: 1, name: 'Лечение кариеса'},
            {id: 2, name: 'Удаление зуба'}
        ],
        serviceRules: [
            v => !!v || 'Service is required',
        ],
        date: '',
        dateRules: [
            v => !!v || 'Service is required',
        ],
    }),
    async mounted() {
        console.log('Component mounted.')
        const response = await axios.get('/api/users', {
            type: 'dentist',
        });

        this.dentists = response.data.data;
        console.log('this.dentists ', this.dentists);
    },
    methods: {
        async makeAnAppointment() {
            const {valid} = await this.$refs.form.validate()

            if (!valid) {
                return false;
            }

            const response = await axios.post('/api/make-an-appointment', {
                name: this.fullName,
                phone: this.phone,
                email: this.email,
                password: this.password,
                dentist: this.dentist,
            });

            console.log('response ', response.data.data.token);

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
            }
        }
    },
}
</script>

<style>
.appointment {
    flex-direction: column;
    align-items: center;
}

.appointment__title {
    width: auto;
    font-weight: bold;
    font-size: 20px;
    margin-top: 50px;
}

.appointment__form {
    width: 500px;
    margin-top: 30px;
}

.appointment__btn {
    margin-top: 30px;
}
</style>
