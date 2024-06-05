import type { $Fetch } from "nitropack";
import { userRepository } from "@/repositories/user";

export const useRepository = () => {
  const { $api } = useNuxtApp();
  const auth = userRepository($api as $Fetch);

  return {
    auth,
  };
};
