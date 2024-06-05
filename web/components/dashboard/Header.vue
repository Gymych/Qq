<template>
  <header
    class="sticky top-0 z-30 flex h-14 items-center gap-4 border-b bg-background px-4 sm:static sm:h-auto sm:border-0 sm:bg-transparent sm:px-6"
  >
    <Sheet>
      <SheetTrigger as-child>
        <Button size="icon" variant="outline" class="sm:hidden">
          <PanelLeft class="h-5 w-5" />
          <span class="sr-only">Toggle Menu</span>
        </Button>
      </SheetTrigger>
      <SheetContent side="left" class="sm:max-w-xs">
        <nav class="grid gap-6 text-lg font-medium">
          <a
            href="#"
            class="group flex h-10 w-10 shrink-0 items-center justify-center gap-2 rounded-full bg-primary text-lg font-semibold text-primary-foreground md:text-base"
          >
            <Package2 class="h-5 w-5 transition-all group-hover:scale-110" />
            <span class="sr-only">Tracking Packages</span>
          </a>
          <a
            href="#"
            class="flex items-center gap-4 px-2.5 text-muted-foreground hover:text-foreground"
          >
            <Home class="h-5 w-5" />
            Dashboard
          </a>
        </nav>
      </SheetContent>
    </Sheet>
    <Breadcrumb class="hidden md:flex">
      <BreadcrumbList>
        <BreadcrumbItem>
          <BreadcrumbLink as-child>
            <a href="#">Dashboard</a>
          </BreadcrumbLink>
        </BreadcrumbItem>
        <BreadcrumbSeparator />
        <BreadcrumbItem>
          <BreadcrumbPage>All Tracking Packages</BreadcrumbPage>
        </BreadcrumbItem>
      </BreadcrumbList>
    </Breadcrumb>
    <div class="relative ml-auto flex-1 md:grow-0"></div>
    <DropdownMenu>
      <DropdownMenuTrigger as-child>
        <Button variant="secondary" size="icon" class="rounded-full">
          <CircleUser class="h-5 w-5" />
          <span class="sr-only">Toggle user menu</span>
        </Button>
      </DropdownMenuTrigger>
      <DropdownMenuContent align="end">
        <DropdownMenuLabel>{{ fullName }}</DropdownMenuLabel>
        <DropdownMenuSeparator />
        <DropdownMenuItem @click.prevent="logoutUser">Logout</DropdownMenuItem>
      </DropdownMenuContent>
    </DropdownMenu>
  </header>
</template>

<script setup lang="ts">
import { CircleUser, Home, Package2, PanelLeft } from "lucide-vue-next";

import { Button } from "@/components/ui/button";

import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator,
} from "@/components/ui/breadcrumb";
import { Sheet, SheetContent, SheetTrigger } from "@/components/ui/sheet";
import { useAuthStore } from "@/store/auth";
import { useSession } from "@/composables/useSession";
const { logout } = useAuthStore();
const session = useSession();

const fullName = ref<string>(
  `${session?.user?.first_name} ${session?.user?.last_name}`
);

const logoutUser = () => {
  logout();
};
</script>
