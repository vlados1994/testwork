<template>
    <div class="container">
        <div class="row justify-content-center dentist">
            <div class="dentist__title">
                Страница дантиста
            </div>
            <v-form
                class="dentist__form"
                ref="form"
                v-model="valid"
            >
                <v-container>
                    <v-row>
                        <v-col
                            cols="12"
                            md="12"
                            style="display: flex; align-items: center"
                        >
                            <div style="margin-left: 15px">
                                id клиента
                            </div>
                            <div style="margin-left: 15px">
                                дата
                            </div>
                            <div style="margin-left: 15px">
                                id услуги
                            </div>
                            <div style="margin-left: 15px">
                                статус
                            </div>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col
                            cols="12"
                            md="12"
                            v-for="schedule in schedules"
                            style="display: flex; align-items: center"
                        >
                            <div style="margin-left: 15px">
                                {{ schedule.client_id }}
                            </div>
                            <div style="margin-left: 15px">
                                {{ schedule.date }}
                            </div>
                            <div style="margin-left: 15px">
                                {{ schedule.service_id }}
                            </div>
                            <div style="margin-left: 60px">
                                {{ getStatus(schedule.status_id) }}
                            </div>
                            <v-responsive
                                style="margin-left: 60px !important;"
                                class="mx-auto dentist__btn"
                                max-width="120"
                            >
                                <v-btn
                                    color="success"
                                    @click="updateStatus(schedule, 2)"
                                >
                                    Закрыть
                                </v-btn>
                            </v-responsive>
                            <v-responsive
                                class="mx-auto dentist__btn"
                                max-width="120"
                            >
                                <v-btn
                                    color="success"
                                    @click="updateStatus(schedule, 3)"
                                >
                                    Отменить
                                </v-btn>
                            </v-responsive>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    data: () => ({
        valid: false,
        schedules: [],
    }),
    async mounted() {
        this.schedules = await this.getSchedules({
            isDentist: true
        });
        console.log('this.schedules', this.schedules);
    },
    methods: {
        ...mapActions([
            'getSchedules',
        ]),
        async updateStatus(schedule, status) {
            const response = await axios.put('/api/schedules/' + schedule.id, {
                status_id: status,
            });
            console.log('response', response);
            this.schedules = await this.getSchedules({
                isDentist: true
            });
        },
        getStatus(statusId) {
            console.log('statusId', statusId);
            switch (statusId) {
                case 1:
                    return 'Запланировано';
                case 2:
                    return 'Закрыто';
                case 3:
                    return 'Отменено';
            }
        }
    },
}
</script>

<style>
.dentist {
    flex-direction: column;
    align-items: center;
}

.dentist__title {
    width: auto;
    font-weight: bold;
    font-size: 20px;
    margin-top: 50px;
}

.dentist__form {
    width: 700px;
    margin-top: 30px;
}

</style>
