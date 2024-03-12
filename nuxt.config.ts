// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: [
    '@nuxtjs/tailwindcss',
    'nuxt-icon'
  ],
  runtimeConfig: {
    'api': 'http://127.0.0.1:8000',
    public: {
      'api': 'http://127.0.0.1:8000'
    }
  },
  app: {
    head: {
      title: "Nuxt & Laravel Auth System",
      link: [
        {
          rel: "shortcut icon",
          href: "/logo.png"
        }
      ],
      charset: 'utf-8',
      viewport: 'width=device-width, initial-scale=1',
      meta: [
        {
          name: "description",
          content: "Build Nuxt & Laravel Auth System with Login/Register/Password-Reset/Email-Verification"
        }
      ]
    }
  },
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {}
    }
  }
})
