<script setup lang="ts">
import { PlusCircle } from "lucide-vue-next";
import Aside from "@components/dashboard/Aside.vue";
import Header from "@components/dashboard/Header.vue";
</script>

<template>
  <div class="flex min-h-screen w-full flex-col bg-muted/40">
    <Aside />
    <div class="flex flex-col sm:gap-4 sm:py-4 sm:pl-14">
      <Header />

      <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
        <div class="flex items-center">
          <div class="ml-auto flex items-center gap-2">
            <Button size="sm" class="h-7 gap-1">
              <PlusCircle class="h-3.5 w-3.5" />
              <span class="sr-only sm:not-sr-only sm:whitespace-nowrap">
                Add Tracking Number
              </span>
            </Button>
          </div>
        </div>
        <slot />
      </main>
    </div>
  </div>
</template>
