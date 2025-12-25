jQuery(document).ready(function ($) {
    jQuery('.project-slider').each(function () {
        var $slider = jQuery(this);
        var $arrows = jQuery('<div class="project-slider-arrows"></div>').insertAfter($slider);

        $slider.slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 1,
            centerMode: true,
            centerPadding: '0px',
            autoplay: true,
            autoplaySpeed: 5000,
            arrows: true,
            appendArrows: $arrows,
            prevArrow: '<button type="button" class="slick-prev"><i class="fac fac-angle-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fac fac-angle-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3, // still show 3
                        centerMode: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        centerMode: true
                    }
                }
            ]
        });
    });

});

const projectsData = {
    '1': {
        title: 'Downtown Commercial Tower',
        location: 'Dubai, UAE',
        category: 'Commercial',
        year: '2024',
        client: 'Premier Development Group',
        size: '450,000 sq ft',
        duration: '18 months',
        mainImage: 'https://images.unsplash.com/photo-1621831337128-35676ca30868?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjb21tZXJjaWFsJTIwYnVpbGRpbmd8ZW58MXx8fHwxNzYwNDMwMzc5fDA&ixlib=rb-4.1.0&q=80&w=1080',
        description: 'A landmark 45-story mixed-use development in the heart of Dubai\'s business district, requiring comprehensive fire protection engineering and life safety systems design.',
        challenge: 'The project presented unique challenges due to its mixed-use nature, combining retail, office, and residential spaces across 45 floors. The building\'s innovative architectural design required creative solutions to meet both local and international fire safety standards while maintaining the architectural vision.',
        solution: 'Our team developed an integrated fire protection strategy incorporating advanced smoke control systems, multiple fire suppression technologies, and a comprehensive life safety plan. We utilized performance-based design approaches to optimize the fire protection systems while ensuring full compliance with UAE Fire and Life Safety Code.',
        services: [
            'Fire Protection Engineering',
            'Smoke Control System Design',
            'Sprinkler System Design',
            'Fire Alarm System Design',
            'Emergency Egress Analysis',
            'Performance-Based Design',
            'Authority Having Jurisdiction (AHJ) Coordination',
            'Construction Administration'
        ],
        outcomes: [
            'Achieved full compliance with UAE Fire and Life Safety Code',
            'Reduced overall fire protection system costs by 15% through optimization',
            'Obtained timely approvals from Civil Defense authorities',
            'Successfully integrated systems with building automation',
            'Delivered comprehensive as-built documentation'
        ]
    },
    '2': {
        title: 'Industrial Manufacturing Complex',
        location: 'Abu Dhabi, UAE',
        category: 'Industrial',
        year: '2024',
        client: 'Global Manufacturing Solutions',
        size: '850,000 sq ft',
        duration: '24 months',
        mainImage: 'https://images.unsplash.com/photo-1705147219565-fe9f6f369d03?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxpbmR1c3RyaWFsJTIwZmFjaWxpdHl8ZW58MXx8fHwxNzYwMzMxOTM5fDA&ixlib=rb-4.1.0&q=80&w=1080',
        description: 'Large-scale industrial manufacturing facility requiring specialized fire suppression systems and comprehensive hazard analysis for chemical processing operations.',
        challenge: 'This project involved complex industrial processes with multiple fire hazards, including flammable liquids, combustible dust, and high-value equipment. The facility required specialized protection systems tailored to different hazard areas while maintaining operational efficiency.',
        solution: 'We conducted a detailed fire hazard analysis and developed zone-specific protection strategies. This included foam suppression systems for flammable liquid areas, early suppression fast response (ESFR) sprinklers for high-piled storage, and clean agent systems for electrical rooms and control centers.',
        services: [
            'Fire Hazard Analysis',
            'Process Safety Consultation',
            'Foam Suppression System Design',
            'ESFR Sprinkler System Design',
            'Clean Agent System Design',
            'Explosion Protection',
            'Emergency Response Planning',
            'Training and Commissioning'
        ],
        outcomes: [
            'Comprehensive protection for all hazard zones',
            'Minimized business interruption risk',
            'Exceeded insurance requirements',
            'Established ongoing maintenance programs',
            'Achieved ISO certification support'
        ]
    },
    '3': {
        title: 'Modern Office Campus',
        location: 'Riyadh, Saudi Arabia',
        category: 'Commercial',
        year: '2023',
        client: 'Technology Innovations Ltd',
        size: '320,000 sq ft',
        duration: '14 months',
        mainImage: 'https://images.unsplash.com/photo-1715593949273-09009558300a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxvZmZpY2UlMjBpbnRlcmlvcnxlbnwxfHx8fDE3NjA0Mjc1NDJ8MA&ixlib=rb-4.1.0&q=80&w=1080',
        description: 'Multi-building corporate campus featuring state-of-the-art office spaces, requiring integrated fire protection and life safety systems across all facilities.',
        challenge: 'The campus consisted of five interconnected buildings with varying occupancy types and heights. The challenge was to create a cohesive fire protection strategy that addressed each building\'s unique requirements while ensuring seamless integration across the campus.',
        solution: 'We designed a campus-wide fire protection master plan with centralized monitoring and distributed control systems. The solution included addressable fire alarm systems, pre-action sprinkler systems for IT areas, and an integrated mass notification system for emergency communications.',
        services: [
            'Master Fire Protection Planning',
            'Addressable Fire Alarm Design',
            'Pre-Action Sprinkler Systems',
            'Mass Notification Systems',
            'Emergency Evacuation Planning',
            'Fire Department Coordination',
            'System Integration Design',
            'Commissioning and Testing'
        ],
        outcomes: [
            'Unified protection across all buildings',
            'Enhanced emergency response capabilities',
            'Streamlined maintenance and monitoring',
            'Compliance with Saudi Building Code',
            'LEED certification support'
        ]
    },
    '4': {
        title: 'Luxury Residential Development',
        location: 'Doha, Qatar',
        category: 'Residential',
        year: '2023',
        client: 'Elite Living Developments',
        size: '280,000 sq ft',
        duration: '16 months',
        mainImage: 'https://images.unsplash.com/photo-1519662978799-2f05096d3636?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtb2Rlcm4lMjBhcmNoaXRlY3R1cmV8ZW58MXx8fHwxNzYwMzk1NDY2fDA&ixlib=rb-4.1.0&q=80&w=1080',
        description: 'High-end residential towers requiring sophisticated fire protection systems that maintain aesthetic appeal while ensuring maximum safety for residents.',
        challenge: 'Balancing the stringent fire safety requirements with the luxury aesthetic and resident experience expectations. The project required concealed systems and minimal visual impact while maintaining code compliance and optimal protection.',
        solution: 'Our team developed an elegant fire protection solution featuring concealed sprinklers, aesthetic detector designs, and integrated building systems. We worked closely with interior designers to ensure all safety features complemented the luxury finishes.',
        services: [
            'Residential Fire Protection Design',
            'Concealed Sprinkler System Design',
            'Voice Evacuation System Design',
            'Pressurization System Design',
            'Aesthetic Integration Planning',
            'Resident Safety Education',
            'Code Compliance Analysis',
            'Final Acceptance Testing'
        ],
        outcomes: [
            'Seamless integration with luxury interiors',
            'Enhanced resident safety and peace of mind',
            'Full Qatar Civil Defense approval',
            'Positive feedback from residents and management',
            'Award recognition for design excellence'
        ]
    },
    '5': {
        title: 'Infrastructure Construction Project',
        location: 'Kuwait City, Kuwait',
        category: 'Infrastructure',
        year: '2023',
        client: 'National Infrastructure Authority',
        size: '1,200,000 sq ft',
        duration: '30 months',
        mainImage: 'https://images.unsplash.com/photo-1487491424367-7571f9afbb30?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjb25zdHJ1Y3Rpb24lMjBlbmdpbmVlcmluZ3xlbnwxfHx8fDE3NjAzMjIxNDJ8MA&ixlib=rb-4.1.0&q=80&w=1080',
        description: 'Critical infrastructure development requiring comprehensive fire protection consultation for tunnels, stations, and support facilities.',
        challenge: 'Infrastructure projects present unique fire protection challenges including limited egress routes, confined spaces, and potential for rapid fire spread. The project required specialized systems and strategies to protect both the structure and occupants.',
        solution: 'We developed a multi-layered fire protection strategy incorporating fire detection, suppression, ventilation, and egress systems specifically designed for infrastructure applications. Our solution included tunnel fire protection systems, emergency ventilation, and robust emergency response protocols.',
        services: [
            'Infrastructure Fire Protection Engineering',
            'Tunnel Fire Protection Design',
            'Emergency Ventilation Systems',
            'Fire Detection and Alarm Systems',
            'Water-Based Suppression Systems',
            'Emergency Response Planning',
            'Fire Safety Risk Assessment',
            'Operations and Maintenance Planning'
        ],
        outcomes: [
            'Industry-leading fire protection standards',
            'Enhanced public safety measures',
            'Compliance with international tunnel standards',
            'Comprehensive operations training program',
            'Recognition from safety authorities'
        ]
    },
    '6': {
        title: 'Healthcare Facility Expansion',
        location: 'Manama, Bahrain',
        category: 'Healthcare',
        year: '2022',
        client: 'Regional Medical Center',
        size: '180,000 sq ft',
        duration: '20 months',
        mainImage: 'https://images.unsplash.com/photo-1722227089176-a981d2544b5f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxmaXJlJTIwc2FmZXR5JTIwYnVpbGRpbmd8ZW58MXx8fHwxNzYwNDMwMzc4fDA&ixlib=rb-4.1.0&q=80&w=1080',
        description: 'Hospital expansion project requiring specialized fire protection engineering to protect vulnerable populations and critical medical operations.',
        challenge: 'Healthcare facilities require the highest level of fire protection due to non-ambulatory patients and critical life support systems. The expansion needed to integrate with existing hospital systems while meeting stringent healthcare fire safety standards.',
        solution: 'We designed a defend-in-place fire protection strategy with smoke compartmentation, advanced detection systems, and specialized suppression solutions. The design prioritized patient safety while allowing continued medical operations during emergencies.',
        services: [
            'Healthcare Fire Protection Engineering',
            'Smoke Compartmentation Design',
            'Operating Room Fire Protection',
            'Medical Gas System Safety',
            'Early Warning Detection Systems',
            'Staff Training and Drills',
            'Infection Control Coordination',
            'Phased Implementation Planning'
        ],
        outcomes: [
            'Zero disruption to hospital operations',
            'Enhanced patient and staff safety',
            'Accreditation compliance achieved',
            'Successful integration with existing systems',
            'Recognition for safety excellence'
        ]
    }
};

// Get project ID from URL
const urlParams = new URLSearchParams(window.location.search);
const projectId = urlParams.get('id') || '1';
const project = projectsData[projectId];

if (project) {
    // Populate hero section
    document.getElementById('heroImage').src = project.mainImage;
    document.getElementById('heroImage').alt = project.title;
    document.getElementById('projectBadge').textContent = project.category;
    document.getElementById('projectTitle').textContent = project.title;
    document.getElementById('projectLocation').textContent = project.location;
    document.getElementById('projectYear').textContent = project.year;
    document.getElementById('projectSize').textContent = project.size;

    // Populate main content
    document.getElementById('projectDescription').textContent = project.description;
    document.getElementById('projectChallenge').textContent = project.challenge;
    document.getElementById('projectSolution').textContent = project.solution;

    // Populate services
    const servicesList = document.getElementById('servicesList');
    project.services.forEach(service => {
        const serviceItem = document.createElement('div');
        serviceItem.className = 'service-item';
        serviceItem.innerHTML = `
                    <i class="bi bi-check-circle-fill"></i>
                    <span>${service}</span>
                `;
        servicesList.appendChild(serviceItem);
    });

    // Populate outcomes
    const outcomesList = document.getElementById('outcomesList');
    project.outcomes.forEach(outcome => {
        const outcomeItem = document.createElement('div');
        outcomeItem.className = 'outcome-item';
        outcomeItem.innerHTML = `
                    <i class="bi bi-check-circle-fill"></i>
                    <span>${outcome}</span>
                `;
        outcomesList.appendChild(outcomeItem);
    });

    // Populate sidebar
    document.getElementById('projectClient').textContent = project.client;
    document.getElementById('sidebarLocation').textContent = project.location;
    document.getElementById('sidebarSize').textContent = project.size;
    document.getElementById('projectDuration').textContent = project.duration;
    document.getElementById('sidebarYear').textContent = project.year;

    // Update page title
    document.title = `${project.title} - Red Helmet Engineering`;
}



