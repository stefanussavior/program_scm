<?php

/*
 * This file is part of the Predis package.
 *
 * (c) 2009-2020 Daniele Alessandri
 * (c) 2021-2023 Till Krüss
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Command\Redis;

/**
 * @group commands
 * @group realm-list
 */
class RPUSHX_Test extends PredisCommandTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getExpectedCommand(): string
    {
        return 'Predis\Command\Redis\RPUSHX';
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedId(): string
    {
        return 'RPUSHX';
    }

    /**
     * @group disconnected
     */
    public function testFilterArguments(): void
    {
        $arguments = ['key', 'value'];
        $expected = ['key', 'value'];

        $command = $this->getCommand();
        $command->setArguments($arguments);

        $this->assertSame($expected, $command->getArguments());
    }

    /**
     * @group disconnected
     */
    public function testParseResponse(): void
    {
        $this->assertSame(1, $this->getCommand()->parseResponse(1));
    }

    /**
     * @group connected
     * @requiresRedisVersion >= 2.2.0
     */
    public function testPushesElementsToHeadOfExistingList(): void
    {
        $redis = $this->getClient();

        $redis->rpush('metavars', 'foo');

        $this->assertSame(2, $redis->rpushx('metavars', 'hoge'));
        $this->assertSame(['foo', 'hoge'], $redis->lrange('metavars', 0, -1));
    }

    /**
     * @group connected
     * @requiresRedisVersion >= 2.2.0
     */
    public function testDoesNotPushElementOnNonExistingKey(): void
    {
        $redis = $this->getClient();

        $this->assertSame(0, $redis->rpushx('metavars', 'foo'));
        $this->assertSame(0, $redis->rpushx('metavars', 'hoge'));
        $this->assertSame(0, $redis->exists('metavars'));
    }

    /**
     * @group connected
     * @requiresRedisVersion >= 2.2.0
     */
    public function testThrowsExceptionOnWrongType(): void
    {
        $this->expectException('Predis\Response\ServerException');
        $this->expectExceptionMessage('Operation against a key holding the wrong kind of value');

        $redis = $this->getClient();

        $redis->set('metavars', 'foo');
        $redis->rpushx('metavars', 'hoge');
    }
}