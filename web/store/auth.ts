import { defineStore } from "pinia";
import { useRepository } from "@/composables/useRepository";

interface UserDataInterface {
  access_token: string;
  user: {
    first_name: string;
    last_name: string;
    email: string;
  };
}

export const useAuthStore = defineStore("auth", {
  state: () => ({
    authenticated: false,
    loading: false,
    session: {} as UserDataInterface,
  }),
  actions: {
    async login(email: string, password: string) {
      try {
        const { auth } = useRepository();
        const response = await auth.login(email, password);

        if (response) {
          const token = useCookie<UserDataInterface>("session");
          token.value = response?.data;
          this.authenticated = true;
          this.session = response?.data;

          navigateTo("/dashboard");
        }
      } catch (error) {
        return null;
      }
    },
    updateAuthenticated(isAuthenticated: boolean) {
      this.authenticated = isAuthenticated;
    },
    logout() {
      const token = useCookie("session");
      this.authenticated = false;
      token.value = null;

      navigateTo("/");
    },
  },
});
