import type { NitroFetchRequest, $Fetch } from "nitropack";

type Payload = {
  success: boolean;
  code: number;
  locale: string;
  message: string;
  data: {
    token_type: string;
    access_token: string;
    email_verified_at: string;
    expires_in: string;
    expires_at: string;
    user: {
      first_name: string;
      last_name: string;
      email: string;
    };
  };
};

export const userRepository = <T>(fetch: $Fetch<T, NitroFetchRequest>) => ({
  async login(email: string, password: string): Promise<Payload | null> {
    try {
      return fetch<Payload>("/auth/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: { email, password },
      });
    } catch (error) {
      return null;
    }
  },
});
