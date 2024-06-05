interface UserDataInterface {
  access_token: string;
  user: {
    first_name: string;
    last_name: string;
    email: string;
  };
}
export const useSession = (): UserDataInterface | null => {
  return useCookie<UserDataInterface>("session").value;
};
