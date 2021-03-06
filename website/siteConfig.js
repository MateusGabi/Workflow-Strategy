/**
 * Copyright (c) 2017-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

/* List of projects/orgs using your project for the users page */
const users = [
    {
        caption: 'User1',
        image: '/test-site/img/docusaurus.svg',
        infoLink: 'https://www.facebook.com',
        pinned: true,
    },
];

const siteConfig = {
    title: 'Workflow Strategy' /* title for your website */,
    tagline: 'Approach to the implementation of business rules',
    url: 'https://mateusgabi.github.io/' /* your website url */,
    baseUrl: '/Workflow-Strategy/' /* base url for your project */,
    projectName: 'Workflow-Strategy',
    headerLinks: [
        { doc: 'doc1', label: 'Docs' },
        { doc: 'doc4', label: 'API' },
        { page: 'help', label: 'Help' },
        { blog: true, label: 'Blog' },
    ],
    users,
    /* path to images for header/footer */
    headerIcon: 'img/docusaurus.svg',
    footerIcon: 'img/docusaurus.svg',
    favicon: 'img/favicon.png',
    /* colors for website */
    colors: {
        primaryColor: '#423d3d',
        secondaryColor: '#205C3B',
    },
    // This copyright info is used in /core/Footer.js and blog rss/atom feeds.
    copyright:
        'Copyright © ' +
        new Date().getFullYear() +
        ' Mateus Gabi Moreira',
    organizationName: 'mateusgabi', // or set an env variable ORGANIZATION_NAME
    projectName: 'Workflow-Strategy', // or set an env variable PROJECT_NAME
    highlight: {
        // Highlight.js theme to use for syntax highlighting in code blocks
        theme: 'default',
    },
    scripts: ['https://buttons.github.io/buttons.js'],
    // You may provide arbitrary config keys to be used as needed by your template.
    repoUrl: 'https://github.com/MateusGabi/Workflow-Strategy',
};

module.exports = siteConfig;
