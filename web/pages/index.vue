<script setup lang="ts">
import { Button } from "@components/ui/button";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@components/ui/card";
import { Input } from "@components/ui/input";
import { Label } from "@components/ui/label";
import { useAuthStore } from "@/store/auth";

const { login } = useAuthStore();

definePageMeta({ auth: "guest" });

const user = reactive({
  email: "",
  password: "",
});

const loginWithCredentials = async () => {
  await login(user.email, user.password);
};
</script>

<template>
  <Card class="w-full max-w-sm">
    <CardHeader>
      <CardTitle class="text-2xl"> Login</CardTitle>
      <CardDescription>
        Enter your email below to login to your account.
      </CardDescription>
    </CardHeader>
    <CardContent class="grid gap-4">
      <div class="grid gap-2">
        <Label for="email">Email</Label>
        <Input
          id="email"
          v-model="user.email"
          type="email"
          placeholder="m@example.com"
          required
        />
      </div>
      <div class="grid gap-2">
        <Label for="password">Password</Label>
        <Input id="password" v-model="user.password" type="password" required />
      </div>
    </CardContent>
    <CardFooter>
      <Button class="w-full" @click.prevent="loginWithCredentials">
        Sign in
      </Button>
    </CardFooter>
  </Card>
</template>
