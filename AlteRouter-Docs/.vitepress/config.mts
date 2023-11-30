import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  srcDir: 'src',
  base: '/AlteRouter-Docs/',
  locales: {
    root: {
      label: 'English',
      lang: 'en',
    },
    fr: {
      label: 'French',
      lang: 'fr',
      link: '/fr/',
      themeConfig: {
        nav: [
          { text: 'Accueil', link: '/fr' },
          { text: 'Documents', link: '/fr/introduction/getting-started' }
        ],
        sidebar: [
          {
            text: 'Introduction',
            items: [
              { text: 'Qu\'est-ce que AlteRouter', link: '/fr/introduction/what-is-alterouter' },
              { text: 'Guide de démarrage', link: '/fr/introduction/getting-started' },
              { text: 'Changelog', link: '/fr/introduction/changelog' }
            ]
          },
          {
            text: 'API',
            items: [
              { text: 'AlteRouter', link: '/fr/api/alterouter' },
              { text: 'Route', link: '/fr/api/route' },
              { text: 'Request', link: '/fr/api/request' },
              { text: 'PathParameterAliasRegex', link: '/fr/api/pathparameteraliasregex' },
            ]
          }
        ],

        socialLinks: [
          { icon: 'github', link: 'https://github.com/quenti77/AlteRouter' }
        ]
      }
    }
  },
  title: "AlteRouter",
  description: "Documentation of AlteRouter",
  themeConfig: {
    nav: [
      { text: 'Home', link: '/' },
      { text: 'Docs', link: '/introduction/getting-started' }
    ],
    sidebar: [
      {
        text: 'Introduction',
        items: [
          { text: 'What is AlteRouter', link: '/introduction/what-is-alterouter' },
          { text: 'Getting Started', link: '/introduction/getting-started' },
          { text: 'Changelog', link: '/introduction/changelog' }
        ]
      },
      {
        text: 'API',
        items: [
          { text: 'AlteRouter', link: '/api/alterouter' },
          { text: 'Route', link: '/api/route' },
          { text: 'Request', link: '/api/request' },
          { text: 'PathParameterAliasRegex', link: '/api/pathparameteraliasregex' },
        ]
      }
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/quenti77/AlteRouter' }
    ]
  }
})
