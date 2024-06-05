import { useAuthStore } from "@/store/auth";

export default defineNuxtRouteMiddleware((to) => {
  const authStore = useAuthStore();
  const { authenticated } = storeToRefs(authStore);
  const token = useCookie("session");

  // Check and update authentication status
  authStore.updateAuthenticated(!!token.value); // Direct store update

  // Handle routing logic
  if (authenticated.value) {
    if (to.path === "/") {
      // Redirect authenticated users from home to dashboard
      return navigateTo("/dashboard");
    }
  } else {
    if (to.path !== "/") {
      // Unauthenticated users can only access the home page
      abortNavigation();
      return navigateTo("/");
    }
  }
});
