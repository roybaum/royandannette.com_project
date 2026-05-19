<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark text-uppercase" role="navigation" aria-label="Main navigation">
	<div class="container">
		<a class="navbar-brand" href="<?php echo Theme::siteUrl(); ?>">
			<span class="text-white"><?php echo $site->title(); ?></span>
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="<?php echo $L->get('Toggle navigation'); ?>">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">

			<ul class="navbar-nav ml-auto">
				<?php
				$topLevelMenuKeys = array('states', 'challenges', 'more', 'contact');

				foreach ($topLevelMenuKeys as $menuKey):
					$menuPage = buildPage($menuKey);
					if (!$menuPage) {
						continue;
					}

					$isCurrent = false;
					if ($WHERE_AM_I === 'home' && $menuKey === 'home') {
						$isCurrent = true;
					} elseif ($page) {
						$currentKey = $page->key();
						$isCurrent = ($currentKey === $menuPage->key()) || Text::startsWith($currentKey, $menuPage->key() . '/');
					}

					$children = $menuPage->children();

					// Fallback for content trees where parent is stored in DB field but keys are not nested.
					if (empty($children) && isset($pages)) {
						$publishedPagesDB = $pages->getPublishedDB(false);
						$childRows = array();

						foreach ($publishedPagesDB as $candidateKey => $candidateFields) {
							if (isset($candidateFields['parent']) && $candidateFields['parent'] === $menuPage->key()) {
								$childRows[] = array(
									'key' => $candidateKey,
									'position' => (int) $candidateFields['position']
								);
							}
						}

						usort($childRows, function ($a, $b) {
							return $a['position'] <=> $b['position'];
						});

						foreach ($childRows as $childRow) {
							$childPage = buildPage($childRow['key']);
							if ($childPage) {
								$children[] = $childPage;
							}
						}
					}

					$hasChildren = !empty($children);
				?>

				<?php if ($hasChildren): ?>
				<li class="nav-item dropdown<?php echo $isCurrent ? ' active' : ''; ?>">
					<a class="nav-link dropdown-toggle" href="<?php echo $menuPage->permalink(); ?>" id="navDropdown-<?php echo $menuPage->key(); ?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo $menuPage->title(); ?>
					</a>
					<div class="dropdown-menu" aria-labelledby="navDropdown-<?php echo $menuPage->key(); ?>">
						<?php foreach ($children as $childPage): ?>
							<a class="dropdown-item" href="<?php echo $childPage->permalink(); ?>"><?php echo $childPage->title(); ?></a>
						<?php endforeach; ?>
					</div>
				</li>
				<?php else: ?>
				<li class="nav-item<?php echo $isCurrent ? ' active' : ''; ?>">
					<a class="nav-link" href="<?php echo $menuPage->permalink(); ?>">
						<?php echo $menuPage->title(); ?>
						<?php if ($isCurrent): ?>
							<span class="sr-only">(<?php echo $L->get('current'); ?>)</span>
						<?php endif; ?>
					</a>
				</li>
				<?php endif; ?>
				<?php endforeach; ?>

				<!-- Social Networks -->
				<?php foreach (Theme::socialNetworks() as $key=>$label): ?>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo $site->{$key}(); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo $label; ?>">
						<img class="d-none d-md-inline-block nav-svg-icon" src="<?php echo DOMAIN_THEME.'img/'.$key.'.svg' ?>" alt="" aria-hidden="true" />
						<span class="d-inline d-md-none"><?php echo $label; ?></span>
						<span class="sr-only d-none d-md-inline"><?php echo $label; ?></span>
					</a>
				</li>
				<?php endforeach; ?>

				<!-- RSS -->
				<?php if (Theme::rssUrl()): ?>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo Theme::rssUrl() ?>" target="_blank" rel="noopener noreferrer" title="RSS Feed">
						<img class="d-none d-md-inline-block nav-svg-icon" src="<?php echo DOMAIN_THEME.'img/rss.svg' ?>" alt="" aria-hidden="true" />
						<span class="d-inline d-md-none">RSS</span>
						<span class="sr-only d-none d-md-inline">RSS Feed</span>
					</a>
				</li>
				<?php endif; ?>

			</ul>

		</div>
	</div>
</nav>
